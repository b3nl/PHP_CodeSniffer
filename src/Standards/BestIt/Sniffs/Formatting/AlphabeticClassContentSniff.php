<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Formatting;

use BestIt\CodeSniffer\Helper\TokenHelper;
use BestIt\Sniffs\AbstractSniff;
use BestIt\Sniffs\ClassRegistrationTrait;
use PHP_CodeSniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\PropertyHelper;

use function array_column;
use function array_filter;
use function array_key_last;
use function array_keys;
use function array_push;
use function count;
use function in_array;
use function natsort;

use const ARRAY_FILTER_USE_BOTH;
use const T_ARRAY;
use const T_ATTRIBUTE_END;
use const T_CLOSURE;
use const T_COMMA;
use const T_CONST;
use const T_DOC_COMMENT_CLOSE_TAG;
use const T_DOC_COMMENT_OPEN_TAG;
use const T_EQUAL;
use const T_FUNCTION;
use const T_NULLABLE;
use const T_OPEN_CURLY_BRACKET;
use const T_SEMICOLON;
use const T_STRING;
use const T_VARIABLE;
use const T_WHITESPACE;

/**
 * Registers a fixable warning, if the constants, properties or methods are not sorted alphabetically.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Formatting
 */
class AlphabeticClassContentSniff extends AbstractSniff
{
    use ClassRegistrationTrait;

    /**
     * You SHOULD sort your constants, methods and properties alphabetically, each kind on its own.
     */
    public const CODE_SORT_ALPHABETICALLY = 'SortAlphabetically';

    /**
     * The modifiers and types in front of a member declaration.
     */
    private const DECLARATION_PREFIX_TOKENS = [
        ...TokenHelper::MODIFIERS_TOKEN_CODES,
        ...TokenHelper::TYPE_HINT_TOKEN_CODES,
        T_ARRAY,
        T_CONST,
        T_NULLABLE,
    ];

    /**
     * The message for the wrong sorting.
     */
    private const MESSAGE_SORT_ALPHABETICALLY = 'Please sort your contents alphabetically.';

    /**
     * Registers the warnings and returns true, if the members should be fixed.
     *
     * @param array $misplacedMembers The members which are not on their sorted position.
     * @param bool $isFixable Can the sorting of this kind of member be fixed safely?
     *
     * @return bool True if every warning was registered as fixable and the fixer is running.
     */
    private function addSortingWarnings(array $misplacedMembers, bool $isFixable): bool
    {
        $withFix = $isFixable;

        foreach ($misplacedMembers as $member) {
            if (!$isFixable) {
                $this->file->addWarning(
                    self::MESSAGE_SORT_ALPHABETICALLY,
                    $member['namePos'],
                    static::CODE_SORT_ALPHABETICALLY,
                );

                continue;
            }

            $withFix = $this->file->addFixableWarning(
                self::MESSAGE_SORT_ALPHABETICALLY,
                $member['namePos'],
                static::CODE_SORT_ALPHABETICALLY,
            ) && $withFix;
        }

        return $withFix;
    }

    /**
     * Checks and fixes the sorting of the members of the token type.
     *
     * @param int $tokenType The token type of the members.
     *
     * @return void
     */
    private function checkAndFixSortingOfType(int $tokenType): void
    {
        $members = $this->getMembersOfType($tokenType);
        $sortedMembers = $this->sortMembers($members);

        $misplacedMembers = array_filter(
            $members,
            static fn (array $member, int $index): bool => $sortedMembers[$index]['name'] !== $member['name'],
            ARRAY_FILTER_USE_BOTH,
        );

        if (!$misplacedMembers) {
            return;
        }

        if ($this->addSortingWarnings($misplacedMembers, $this->isFixable($members, $misplacedMembers))) {
            $this->fixSorting($members, $sortedMembers);
        }
    }

    /**
     * Returns the end of the declaration with its top level assignments and commas.
     *
     * @param int $startPos The position to start the search after.
     * @param bool $endsWithBlock Can the declaration end with a block (property hooks)?
     *
     * @return array The end position, the assignment positions and the comma flag.
     */
    private function findDeclarationEnd(int $startPos, bool $endsWithBlock = false): array
    {
        $declaration = ['endPos' => $this->token['scope_closer'], 'equalPoss' => [], 'hasComma' => false];

        for ($pos = $startPos + 1; $pos < $this->token['scope_closer']; ++$pos) {
            $token = $this->tokens[$pos];

            if ($token['code'] === T_SEMICOLON) {
                $declaration['endPos'] = $pos;

                break;
            }

            if ($endsWithBlock && ($token['code'] === T_OPEN_CURLY_BRACKET)) {
                $declaration['endPos'] = $token['bracket_closer'];

                break;
            }

            if ($token['code'] === T_EQUAL) {
                $declaration['equalPoss'][] = $pos;
            }

            if ($token['code'] === T_COMMA) {
                $declaration['hasComma'] = true;
            }

            $pos = $token['code'] === T_CLOSURE
                ? $token['scope_closer']
                : $token['parenthesis_closer'] ?? $token['bracket_closer'] ?? $pos;
        }

        return $declaration;
    }

    /**
     * Returns the start of the member including its doc block, attributes and modifiers.
     *
     * @param int $pos The position of the keyword or variable of the member.
     *
     * @return int The position of the first token of the member declaration.
     */
    private function findMemberStart(int $pos): int
    {
        $startPos = $pos;

        for ($checkPos = $pos - 1; $checkPos > $this->token['scope_opener']; --$checkPos) {
            $token = $this->tokens[$checkPos];

            if ($token['code'] === T_WHITESPACE) {
                continue;
            }

            if ($token['code'] === T_ATTRIBUTE_END) {
                $startPos = $checkPos = $token['attribute_opener'];

                continue;
            }

            if ($token['code'] === T_DOC_COMMENT_CLOSE_TAG) {
                $startPos = $checkPos = $token['comment_opener'];

                continue;
            }

            if (!in_array($token['code'], self::DECLARATION_PREFIX_TOKENS, true)) {
                break;
            }

            $startPos = $checkPos;
        }

        return $startPos;
    }

    /**
     * Moves the misplaced members to their sorted position in one changeset.
     *
     * @param array $members The members in their original order.
     * @param array $sortedMembers The members in their sorted order.
     *
     * @return void
     */
    private function fixSorting(array $members, array $sortedMembers): void
    {
        $fixer = $this->file->fixer;

        $fixer->beginChangeset();

        foreach ($members as $index => $member) {
            $sortedMember = $sortedMembers[$index];

            if ($sortedMember['name'] === $member['name']) {
                continue;
            }

            $fixer->replaceToken(
                $member['startPos'],
                $this->file->getTokensAsString(
                    $sortedMember['startPos'],
                    $sortedMember['endPos'] - $sortedMember['startPos'] + 1,
                    true,
                ),
            );

            for ($pos = $member['startPos'] + 1; $pos <= $member['endPos']; ++$pos) {
                $fixer->replaceToken($pos, '');
            }
        }

        $fixer->endChangeset();
    }

    /**
     * Returns the constants of the const statement, named by the token before their assignment.
     *
     * @param int $constPos The position of the const keyword.
     *
     * @return array The constant members of this statement.
     */
    private function getConstantMembers(int $constPos): array
    {
        $declaration = $this->findDeclarationEnd($constPos);
        $members = [];

        foreach ($declaration['equalPoss'] as $equalPos) {
            $namePos = TokenHelper::findPreviousEffective($this->file, $equalPos - 1);

            $members[] = [
                'endPos' => $declaration['endPos'],
                'isSingleDeclaration' => count($declaration['equalPoss']) === 1,
                'name' => $this->tokens[$namePos]['content'],
                'namePos' => $namePos,
                'startPos' => $this->findMemberStart($constPos),
            ];
        }

        return $members;
    }

    /**
     * Returns the members of the sniffed class like structure for the token type.
     *
     * @param int $tokenType The token type of the members.
     *
     * @return array The members in their original order.
     */
    private function getMembersOfType(int $tokenType): array
    {
        $members = [];
        $tokenPoss = TokenHelper::findNextAll(
            $this->file,
            [$tokenType],
            $this->stackPos + 1,
            $this->token['scope_closer'],
        );

        foreach ($tokenPoss as $tokenPos) {
            if (!$this->isMemberOfThisScope($tokenPos)) {
                continue;
            }

            if (($tokenType === T_VARIABLE) && (!PropertyHelper::isProperty($this->file, $tokenPos))) {
                continue;
            }

            array_push($members, ...match ($tokenType) {
                T_CONST => $this->getConstantMembers($tokenPos),
                T_FUNCTION => [$this->getMethodMember($tokenPos)],
                default => [$this->getPropertyMember($tokenPos)],
            });
        }

        return $members;
    }

    /**
     * Returns the method member for the given function keyword.
     *
     * @param int $functionPos The position of the function keyword.
     *
     * @return array The method member.
     */
    private function getMethodMember(int $functionPos): array
    {
        $namePos = $this->file->findNext([T_STRING], $functionPos);

        return [
            'endPos' => $this->tokens[$functionPos]['scope_closer']
                ?? $this->findDeclarationEnd($this->tokens[$functionPos]['parenthesis_closer'])['endPos'],
            'isSingleDeclaration' => true,
            'name' => $this->tokens[$namePos]['content'],
            'namePos' => $namePos,
            'startPos' => $this->findMemberStart($functionPos),
        ];
    }

    /**
     * Returns the property member for the given variable.
     *
     * @param int $variablePos The position of the property variable.
     *
     * @return array The property member.
     */
    private function getPropertyMember(int $variablePos): array
    {
        $declaration = $this->findDeclarationEnd($variablePos, true);

        return [
            'endPos' => $declaration['endPos'],
            'isSingleDeclaration' => !$declaration['hasComma'],
            'name' => $this->tokens[$variablePos]['content'],
            'namePos' => $variablePos,
            'startPos' => $this->findMemberStart($variablePos),
        ];
    }

    /**
     * Is the token a comment, a doc block or a phpcs annotation?
     *
     * @param int $tokenPos The position of the checked token.
     *
     * @return bool True if the token is one of the comment tokens.
     */
    private function isComment(int $tokenPos): bool
    {
        return isset(Tokens::COMMENT_TOKENS[$this->tokens[$tokenPos]['code']]);
    }

    /**
     * Can the misplaced members be swapped safely?
     *
     * @param array $members All members of one kind.
     * @param array $misplacedMembers The members of this kind which need to move.
     *
     * @return bool True if every declaration is single and every misplaced member is movable.
     */
    private function isFixable(array $members, array $misplacedMembers): bool
    {
        $isFixable = true;

        foreach ($members as $member) {
            $isFixable = $isFixable && $member['isSingleDeclaration'];
        }

        foreach ($misplacedMembers as $member) {
            $isFixable = $isFixable && $this->isMovable($member);
        }

        return $isFixable;
    }

    /**
     * Is the token the start of a doc block which belongs to the following code?
     *
     * @param int $tokenPos The position of the checked token.
     *
     * @return bool True if code follows the doc block.
     */
    private function isLeadingDocBlock(int $tokenPos): bool
    {
        $isDocBlock = $this->tokens[$tokenPos]['code'] === T_DOC_COMMENT_OPEN_TAG;
        $codePos = $isDocBlock
            ? $this->file->findNext(T_WHITESPACE, $this->tokens[$tokenPos]['comment_closer'] + 1, null, true)
            : $tokenPos;

        return $isDocBlock && !$this->isComment($codePos) && ($codePos !== $this->token['scope_closer']);
    }

    /**
     * Is the token a direct member of the sniffed class and not of a nested scope?
     *
     * @param int $tokenPos The position of the checked token.
     *
     * @return bool True if the innermost condition is the sniffed class.
     */
    private function isMemberOfThisScope(int $tokenPos): bool
    {
        return array_key_last($this->tokens[$tokenPos]['conditions']) === $this->stackPos;
    }

    /**
     * Is the member free of comments which would stay behind?
     *
     * @param array $member The checked member.
     *
     * @return bool True if no foreign comment is next to the member.
     */
    private function isMovable(array $member): bool
    {
        $previousPos = $this->file->findPrevious(T_WHITESPACE, $member['startPos'] - 1, null, true);
        $nextPos = $this->file->findNext(T_WHITESPACE, $member['endPos'] + 1, null, true);

        $hasForeignCommentBefore = $this->isComment($previousPos) && !$this->isTrailingComment($previousPos);
        $hasForeignCommentAfter = $this->isComment($nextPos) && !$this->isLeadingDocBlock($nextPos);

        return !$hasForeignCommentBefore && !$hasForeignCommentAfter;
    }

    /**
     * Is the comment behind other code on the same line?
     *
     * @param int $commentPos The position of the comment.
     *
     * @return bool True if the comment trails the code before it.
     */
    private function isTrailingComment(int $commentPos): bool
    {
        $codePos = $this->file->findPrevious(T_WHITESPACE, $commentPos - 1, null, true);

        return !$this->isComment($codePos) && ($this->tokens[$codePos]['line'] === $this->tokens[$commentPos]['line']);
    }

    /**
     * Processes the token.
     *
     * @return void
     */
    protected function processToken(): void
    {
        $tokenTypes = [T_CONST, T_FUNCTION, T_VARIABLE];

        foreach ($tokenTypes as $tokenType) {
            $this->checkAndFixSortingOfType($tokenType);
        }
    }

    /**
     * Sorts the members naturally and case-sensitively by their name.
     *
     * @param array $members The members in their original order.
     *
     * @return array The sorted members.
     */
    private function sortMembers(array $members): array
    {
        $names = array_column($members, 'name');

        natsort($names);

        $sortedMembers = [];

        foreach (array_keys($names) as $index) {
            $sortedMembers[] = $members[$index];
        }

        return $sortedMembers;
    }
}

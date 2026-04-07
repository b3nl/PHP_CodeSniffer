<?php

declare(strict_types=1);

namespace BestIt\Sniffs\DocTags;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffWarningFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_DOC_COMMENT_OPEN_TAG;

/**
 * Class TagSortingSniffTest
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\DocTags
 */
class TagSortingSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffWarningFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    /**
     * Returns the tokens which should be checked.
     *
     * @return array Returns the expected token ids.
     */
    protected function getExpectedTokens(): array
    {
        return [T_DOC_COMMENT_OPEN_TAG];
    }

    /**
     * Returns the names of the required constants.
     *
     * @return array The required constants of a class. The second value is a possible value which should be checked.
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_MISSING_NEWLINE_BETWEEN_TAGS' => ['CODE_MISSING_NEWLINE_BETWEEN_TAGS', 'MissingNewlineBetweenTags'],
            'CODE_WRONG_TAG_SORTING' => ['CODE_WRONG_TAG_SORTING', 'WrongTagSorting'],
        ];
    }

    /**
     * Sets up the test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->testedObject = new TagSortingSniff();
    }
}

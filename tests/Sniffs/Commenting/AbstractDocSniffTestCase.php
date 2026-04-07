<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Commenting;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHPUnit\Framework\Attributes\DataProvider;

use function defined;

/**
 * Basic test for the summary sniffs.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Commenting
 */
abstract class AbstractDocSniffTestCase extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use TestTokenRegistrationTrait;

    /**
     * The tested class.
     *
     * We use this var to reduce the hard dependencies on internals from a specific slevomat version.
     *
     * @var Sniff|null
     */
    protected ?Sniff $testedObject = null;

    /**
     * Returns the names of the required constants.
     *
     * @return array
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_NO_LINE_AFTER_DOC_COMMENT' => ['CODE_NO_LINE_AFTER_DOC_COMMENT'],
            'CODE_NO_SUMMARY' => ['CODE_NO_SUMMARY'],
            'CODE_SUMMARY_TOO_LONG' => ['CODE_SUMMARY_TOO_LONG'],
            'CODE_DOC_COMMENT_UC_FIRST' => ['CODE_DOC_COMMENT_UC_FIRST'],
        ];
    }

    /**
     * Checks if the api is extended.
     *
     * @param string $constant The name of the constant.
     *
     * @return void
     */
    #[DataProvider('getRequiredConstantAsserts')]
    public function testRequiredConstants(string $constant): void
    {
        static::assertTrue(
            defined(get_class($this->testedObject) . '::' . $constant),
            'Constant ' . $constant . ' is missing.',
        );
    }
}

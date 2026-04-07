<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Spacing;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_CONST;

/**
 * Test ConstantSpacingSniff
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Spacing
 */
class ConstantSpacingSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use TestTokenRegistrationTrait;
    use TestRequiredConstantsTrait;

    /**
     * Which tokens are expected?
     *
     * @return array
     */
    protected function getExpectedTokens(): array
    {
        return [
            T_CONST,
        ];
    }

    /**
     * Checks which constants are required.
     *
     * @return iterable
     */
    public static function getRequiredConstantAsserts(): iterable
    {
        return [
            'CODE_INCORRECT_COUNT_OF_BLANK_LINES_AFTER_CONSTANT' => [
                'CODE_INCORRECT_COUNT_OF_BLANK_LINES_AFTER_CONSTANT',
                'IncorrectCountOfBlankLinesAfterConstant',
            ],
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

        $this->testedObject = new ConstantSpacingSniff();
    }
}

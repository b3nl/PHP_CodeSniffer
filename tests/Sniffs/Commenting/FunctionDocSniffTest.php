<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Commenting;

use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\SniffWarningFilesTrait;

use const T_FUNCTION;

/**
 * Integration test for FunctionSummarySniffTest.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Commenting
 * @see FunctionDocSniff
 */
class FunctionDocSniffTest extends AbstractDocSniffTestCase
{
    use SniffErrorFilesTrait;
    use SniffWarningFilesTrait;

    /**
     * Returns the tokens which should be checked.
     *
     * @return array
     */
    protected function getExpectedTokens(): array
    {
        return [
            T_FUNCTION,
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

        $this->testedObject = new FunctionDocSniff();
    }
}

<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Functions;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffWarningFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_PRIVATE;
use const T_PROTECTED;
use const T_PUBLIC;
use const T_VAR;

/**
 * Checks NoSimplePropertyMethodSniff.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Functions
 */
class NoSimplePropertyMethodSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffWarningFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    /**
     * We should check only functions.
     *
     * @return array
     */
    protected function getExpectedTokens(): array
    {
        return [
            T_VAR,
            T_PUBLIC,
            T_PROTECTED,
            T_PRIVATE,
        ];
    }

    /**
     * Checks if the error codes are there.
     *
     * @return array
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_SHOULD_USE_PROPERTY' => [
                'CODE_SHOULD_USE_PROPERTY',
                'ShouldUseTypedPropertyDirectly',
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

        $this->testedObject = new NoSimplePropertyMethodSniff();
    }
}

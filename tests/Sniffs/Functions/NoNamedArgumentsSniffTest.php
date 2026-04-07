<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Functions;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_PARAM_NAME;

/**
 * Tests NoNamedArgumentsSniff.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Functions
 */
class NoNamedArgumentsSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    /**
     * Returns the expected tokens for registration.
     *
     * @return array
     */
    protected function getExpectedTokens(): array
    {
        return [T_PARAM_NAME];
    }

    /**
     * Returns the required constants.
     *
     * @return array
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_DISALLOWED_NAMED_ARGUMENT' => ['CODE_DISALLOWED_NAMED_ARGUMENT', 'DisallowedNamedArgument'],
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

        $this->testedObject = new NoNamedArgumentsSniff();
    }
}

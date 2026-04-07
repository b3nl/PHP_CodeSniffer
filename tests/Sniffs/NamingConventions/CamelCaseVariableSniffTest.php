<?php

declare(strict_types=1);

namespace BestIt\Sniffs\NamingConventions;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_VARIABLE;

/**
 * Class CamelCapsVariableSniffTest.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\NamingConventions
 */
class CamelCaseVariableSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    /**
     * Returns the tokens which should be checked.
     *
     * @return array Returns the expected token ids.
     */
    protected function getExpectedTokens(): array
    {
        return [T_VARIABLE];
    }

    /**
     * Returns the names of the required constants.
     *
     * @return array The required constants of a class. The second value is a possible value which should be checked.
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_NOT_CAMEL_CASE' => ['CODE_NOT_CAMEL_CASE', 'NotCamelCase'],
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

        $this->testedObject = new CamelCaseVariableSniff();
    }
}

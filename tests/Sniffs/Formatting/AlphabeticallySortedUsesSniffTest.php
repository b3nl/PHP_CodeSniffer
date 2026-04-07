<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Formatting;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_OPEN_TAG;

/**
 * Class AlphabeticallySortedUsesSniffTest
 *
 * @author b3nl <code@b3nl.de>
 * @package BestIt\Sniffs\Formatting
 */
class AlphabeticallySortedUsesSniffTest extends SniffTestCase
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
        return [
            T_OPEN_TAG,
        ];
    }

    /**
     * Returns the names of the required constants.
     *
     * @return array The required constants of a class. The second value is a possible value which should be checked.
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_INCORRECT_ORDER' => ['CODE_INCORRECT_ORDER', 'IncorrectlyOrderedUses'],
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

        $this->testedObject = new AlphabeticallySortedUsesSniff();
    }
}

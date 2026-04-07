<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Formatting;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffWarningFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Class AlphabeticClassContentSniffTest
 *
 * @author Nick Lubisch <nick.lubisch@bestit-online.de>
 * @package BestIt\Sniffs\Formatting
 */
class AlphabeticClassContentSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffWarningFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    /**
     * Returns the tokens which should be checked.
     *
     * @return array The expected token ids.
     */
    protected function getExpectedTokens(): array
    {
        return Tokens::$ooScopeTokens;
    }

    /**
     * Returns the names of the required constants.
     *
     * @return array The required constants of a class. The second value is a possible value which should be checked.
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_SORT_ALPHABETICALLY' => ['CODE_SORT_ALPHABETICALLY', 'SortAlphabetically'],
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

        $this->testedObject = new AlphabeticClassContentSniff();
    }
}

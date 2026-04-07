<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Commenting;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_DOC_COMMENT_STAR;

/**
 * Class RedundantWhitespaceSniffTest
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Commenting
 */
class RedundantWhitespaceSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use TestTokenRegistrationTrait;
    use TestRequiredConstantsTrait;

    /**
     * Returns the tokens which should be checked.
     *
     * @return array Returns the expected token ids.
     */
    protected function getExpectedTokens(): array
    {
        return [
            T_DOC_COMMENT_STAR,
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
            'CODE_ERROR_REDUNDANT_WHITESPACE' => ['CODE_ERROR_REDUNDANT_WHITESPACE', 'RedundantWhitespace'],
        ];
    }

    /**
     * Sets upo the test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->testedObject = new RedundantWhitespaceSniff();
    }
}

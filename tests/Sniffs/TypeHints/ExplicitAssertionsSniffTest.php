<?php

declare(strict_types=1);

namespace BestIt\Sniffs\TypeHints;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_DOC_COMMENT_OPEN_TAG;

/**
 * Tests ExplicitAssertionsSniff
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\TypeHints
 */
class ExplicitAssertionsSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    /**
     * Checks the required tokens.
     *
     * @return array
     */
    protected function getExpectedTokens(): array
    {
        return [
            T_DOC_COMMENT_OPEN_TAG,
        ];
    }

    /**
     * Checks the required constants.
     *
     * @return array
     */
    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_REQUIRED_EXPLICIT_ASSERTION' => ['CODE_REQUIRED_EXPLICIT_ASSERTION', 'RequiredExplicitAssertion'],
        ];
    }

    /**
     * Sets up the test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->testedObject = new ExplicitAssertionsSniff();
    }
}

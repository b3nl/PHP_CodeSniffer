<?php

declare(strict_types=1);

namespace BestIt\Sniffs\DocTags;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Class DisallowedClassTagsSniffTest.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\DocTags
 */
class DisallowedClassTagsSniffTest extends SniffTestCase
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
            'CODE_TAG_NOT_ALLOWED' => ['CODE_TAG_NOT_ALLOWED', 'TagNotAllowed'],
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

        $this->testedObject = new DisallowedClassTagsSniff();
    }

    /**
     * Checks if the api is fulfilled.
     *
     * @return void
     */
    public function testType(): void
    {
        static::assertInstanceOf(AbstractDisallowedTagsSniff::class, $this->testedObject);
    }
}

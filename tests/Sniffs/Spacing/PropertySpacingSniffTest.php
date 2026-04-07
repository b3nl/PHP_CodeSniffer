<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Spacing;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;

use const T_ABSTRACT;
use const T_FINAL;
use const T_PRIVATE;
use const T_PRIVATE_SET;
use const T_PROTECTED;
use const T_PROTECTED_SET;
use const T_PUBLIC;
use const T_PUBLIC_SET;
use const T_READONLY;
use const T_STATIC;
use const T_VAR;

class PropertySpacingSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use TestTokenRegistrationTrait;
    use TestRequiredConstantsTrait;

    protected function getExpectedTokens(): array
    {
        return [
            T_FINAL,
            T_ABSTRACT,
            T_VAR,
            T_PUBLIC,
            T_PUBLIC_SET,
            T_PROTECTED,
            T_PROTECTED_SET,
            T_PRIVATE,
            T_PRIVATE_SET,
            T_READONLY,
            T_STATIC,
        ];
    }

    public static function getRequiredConstantAsserts(): iterable
    {
        return [
            'CODE_INCORRECT_COUNT_OF_BLANK_LINES_AFTER_PROPERTY' => [
                'CODE_INCORRECT_COUNT_OF_BLANK_LINES_AFTER_PROPERTY',
                'IncorrectCountOfBlankLinesAfterProperty',
            ],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testedObject = new PropertySpacingSniff();
    }
}

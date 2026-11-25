<?php

declare(strict_types=1);

namespace BestIt\Sniffs\TypeHints;

use BestIt\Sniffs\SniffCorrectFilesTrait;
use BestIt\Sniffs\SniffErrorFilesTrait;
use BestIt\Sniffs\TestTokenRegistrationTrait;
use BestIt\SniffTestCase;
use BestIt\TestRequiredConstantsTrait;
use Composer\InstalledVersions;

use function version_compare;

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

class PropertyTypeHintSniffTest extends SniffTestCase
{
    use SniffCorrectFilesTrait;
    use SniffErrorFilesTrait;
    use TestRequiredConstantsTrait;
    use TestTokenRegistrationTrait;

    protected function getExpectedTokens(): array
    {
        $expectedTokens = [
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

        // Slevomat registers every property modifier since 8.31.3.
        if (version_compare((string) InstalledVersions::getVersion('slevomat/coding-standard'), '8.31.3', '<')) {
            $expectedTokens = [
                T_VAR,
                T_PUBLIC,
                T_PROTECTED,
                T_PRIVATE,
                T_STATIC,
                T_FINAL,
            ];
        }

        return $expectedTokens;
    }

    public static function getRequiredConstantAsserts(): array
    {
        return [
            'CODE_MISSING_ANY_TYPE_HINT' => ['CODE_MISSING_ANY_TYPE_HINT', 'MissingAnyTypeHint'],
            'CODE_MISSING_NATIVE_TYPE_HINT' => ['CODE_MISSING_NATIVE_TYPE_HINT', 'MissingNativeTypeHint'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->testedObject = new PropertyTypeHintSniff();
    }
}

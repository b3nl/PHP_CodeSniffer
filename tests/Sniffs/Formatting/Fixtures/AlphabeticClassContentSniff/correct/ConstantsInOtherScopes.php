<?php

namespace Test;

interface TypedInterfaceConstants
{
    public const string ALPHA = 'a';

    public const int ZULU = 1;

    public function alpha(): void;

    public function zulu(): void;
}

trait TypedTraitConstants
{
    public const string ALPHA = 'a';

    public const int ZULU = 1;

    private int $alpha = 1;

    private string $zulu = 'z';
}

enum TypedEnumConstants: string
{
    case Zulu = 'z';

    public const string ALPHA = 'a';

    case Alpha = 'a';

    public const self ZULU = self::Zulu;

    public function alpha(): void
    {
    }
}

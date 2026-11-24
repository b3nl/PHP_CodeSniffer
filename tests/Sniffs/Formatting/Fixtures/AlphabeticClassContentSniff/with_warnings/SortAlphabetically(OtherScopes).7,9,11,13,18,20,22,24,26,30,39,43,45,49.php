<?php

namespace Test;

interface OtherInterface
{
    public const int ZULU = 1;

    public const string ALPHA = 'a';

    public function zulu(): void;

    public function alpha(): void;
}

trait OtherTrait
{
    public const ZULU = 'z';

    public const ALPHA = 'a';

    private int $zulu = 1;

    private ?string $alpha = null;

    public function zulu(): void
    {
    }

    public function alpha(): void
    {
    }
}

enum OtherEnum: string
{
    case Zulu = 'z';

    public const self ZULU = self::Zulu;

    case Alpha = 'a';

    public const self ALPHA = self::Alpha;

    public function zulu(): void
    {
    }

    public function alpha(): void
    {
    }
}

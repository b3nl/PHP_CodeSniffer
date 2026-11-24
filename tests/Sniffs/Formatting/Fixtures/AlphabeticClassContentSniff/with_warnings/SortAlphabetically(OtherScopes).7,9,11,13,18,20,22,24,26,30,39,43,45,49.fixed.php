<?php

namespace Test;

interface OtherInterface
{
    public const string ALPHA = 'a';

    public const int ZULU = 1;

    public function alpha(): void;

    public function zulu(): void;
}

trait OtherTrait
{
    public const ALPHA = 'a';

    public const ZULU = 'z';

    private ?string $alpha = null;

    private int $zulu = 1;

    public function alpha(): void
    {
    }

    public function zulu(): void
    {
    }
}

enum OtherEnum: string
{
    case Zulu = 'z';

    public const self ALPHA = self::Alpha;

    case Alpha = 'a';

    public const self ZULU = self::Zulu;

    public function alpha(): void
    {
    }

    public function zulu(): void
    {
    }
}

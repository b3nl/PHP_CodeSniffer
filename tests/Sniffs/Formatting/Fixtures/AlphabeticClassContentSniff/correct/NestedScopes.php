<?php

namespace Test;

class NestedScopes
{
    public const BRAVO = 'b';

    private $bravo;

    public function bravo(int $zulu): object
    {
        $closure = function ($aaa) use ($zulu) {
            return $aaa + $zulu;
        };

        $arrow = fn ($aaa) => $aaa;

        function aaa()
        {
        }

        return new class {
            public const AAA = 'a';

            public const ZZZ = 'z';

            public $aaa;

            public $zzz;

            public function aaa()
            {
            }

            public function zzz()
            {
            }
        };
    }

    public function charlie(): void
    {
    }
}

class PromotedProperties
{
    private $bravo;

    public function __construct(private $aaa, $aaaParameter)
    {
    }
}

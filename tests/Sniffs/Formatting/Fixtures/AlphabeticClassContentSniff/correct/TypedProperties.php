<?php

namespace Test;

class TypedProperties
{
    public static int $alpha = 1;

    private ?string $bravo = null;

    protected int|string $charlie = 1;

    private readonly array $delta;

    private \Foo\Bar $echo;

    public $foxtrot;

    protected static $golf;

    public function __construct(private $aaaUntyped, private int $aaaTyped, $aaaParameter)
    {
    }
}

class PropertyHooks
{
    public string $alpha {
        get => $this->bravo;
        set(string $aaa) {
            $this->bravo = $aaa;
        }
    }

    private(set) string $bravo = '';

    public protected(set) int $charlie = 1;
}

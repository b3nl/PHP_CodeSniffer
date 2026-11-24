<?php

namespace Test;

class Properties
{
    #[Inject]
    public static ?Foo $alpha = null;

    var $bravo;

    protected readonly int|string $mike;

    /**
     * Zulu.
     *
     * @var array
     */
    private array $zulu = [
        'a' => 1,
        'b' => 2,
    ];

    public function __construct(private string $aaa)
    {
    }
}

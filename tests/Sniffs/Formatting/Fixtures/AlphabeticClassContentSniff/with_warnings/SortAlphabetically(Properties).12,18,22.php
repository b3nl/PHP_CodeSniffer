<?php

namespace Test;

class Properties
{
    /**
     * Zulu.
     *
     * @var array
     */
    private array $zulu = [
        'a' => 1,
        'b' => 2,
    ];

    #[Inject]
    public static ?Foo $alpha = null;

    protected readonly int|string $mike;

    var $bravo;

    public function __construct(private string $aaa)
    {
    }
}

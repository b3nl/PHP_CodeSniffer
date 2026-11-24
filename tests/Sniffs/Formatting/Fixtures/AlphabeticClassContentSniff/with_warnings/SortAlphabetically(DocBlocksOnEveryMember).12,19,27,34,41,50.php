<?php

namespace Test;

class DocBlocksOnEveryMember
{
    /**
     * Zulu.
     *
     * @var string
     */
    public const ZULU = 'z';

    /**
     * Alpha.
     *
     * @var string
     */
    public const ALPHA = 'a';

    /**
     * Zulu.
     *
     * @var int
     */
    #[Inject]
    private int $zulu = 1;

    /**
     * Alpha.
     *
     * @var int
     */
    private int $alpha = 1;

    /**
     * Zulu.
     *
     * @return void
     */
    public function zulu(): void
    {
    }

    /**
     * Alpha.
     *
     * @return void
     */
    public function alpha(): void
    {
    }
}

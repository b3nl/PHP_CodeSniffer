<?php

namespace Test;

class DocBlocksOnEveryMember
{
    /**
     * Alpha.
     *
     * @var string
     */
    public const ALPHA = 'a';

    /**
     * Zulu.
     *
     * @var string
     */
    public const ZULU = 'z';

    /**
     * Alpha.
     *
     * @var int
     */
    private int $alpha = 1;

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
     * @return void
     */
    public function alpha(): void
    {
    }

    /**
     * Zulu.
     *
     * @return void
     */
    public function zulu(): void
    {
    }
}

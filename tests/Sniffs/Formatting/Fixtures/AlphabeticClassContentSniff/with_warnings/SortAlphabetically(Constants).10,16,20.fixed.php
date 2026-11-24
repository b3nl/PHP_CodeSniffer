<?php

namespace Test;

class Constants
{
    #[Deprecated]
    public const ALPHA = 'a';

    const MIKE = 'M';

    const Mike = 'm';

    /**
     * Zulu.
     */
    public const ZULU = [
        'a',
        'b',
    ];
}

<?php

namespace Test;

abstract class Methods
{
    #[Pure, Override]
    #[Other(
        'x',
    )]
    protected static function alpha(): int
    {
        return 1;
    }

    /**
     * Bravo.
     */
    final public function &bravo(
        string $foo,
    ): string {
        return $foo;
    }

    abstract public function mike(): void;

    /**
     * Zulu.
     *
     * @return void
     */
    #[Deprecated]
    public function zulu(): void
    {
        $closure = function (int $a) use ($b): int {
            return $a;
        };
    }
}

<?php

namespace Test;

abstract class Methods
{
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

    #[Pure, Override]
    #[Other(
        'x',
    )]
    protected static function alpha(): int
    {
        return 1;
    }

    abstract public function mike(): void;

    /**
     * Bravo.
     */
    final public function &bravo(
        string $foo,
    ): string {
        return $foo;
    }
}

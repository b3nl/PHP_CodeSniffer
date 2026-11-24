<?php

namespace Test;

use Countable;
use Foo;
use Stringable;

class Sample
{
    public const string ALPHA = 'a';

    public const int ZULU = 1;
}

class TypedConstants
{
    const ALPHA = 'untyped';

    public const string BRAVO = 'scalar';

    protected const int CHARLIE = 3;

    private const Foo DELTA = Foo::Bar;

    final public const \Foo\Bar ECHO = \Foo\Bar::Baz;

    public final const ?array FOXTROT = null;

    const int FUNCTION = 1;

    const int|string GOLF = 'union';

    const Countable&Stringable HOTEL = Foo::Hotel;

    const (Countable&Stringable)|null INDIA = null;

    const Foo\Bar JULIET = Foo\Bar::Juliet;

    const namespace\Foo KILO = namespace\Foo::Kilo;

    const self LIMA = self::Lima;
}

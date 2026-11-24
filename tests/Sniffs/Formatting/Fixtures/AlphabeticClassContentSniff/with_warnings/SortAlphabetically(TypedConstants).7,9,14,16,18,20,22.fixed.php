<?php

namespace Test;

class TypedConstantsSortedByType
{
    public const string ALPHA = 'a';

    public const int ZULU = 1;
}

class TypedConstants
{
    const int|string ALPHA = 1;

    private const (Foo&Bar)|null BRAVO = null;

    protected const Foo&Bar XRAY = Foo::Xray;

    public const \Foo\Bar YANKEE = \Foo\Bar::Baz;

    final public const ?string ZULU = null;
}

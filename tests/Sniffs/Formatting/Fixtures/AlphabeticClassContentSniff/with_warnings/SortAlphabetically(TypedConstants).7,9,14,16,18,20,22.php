<?php

namespace Test;

class TypedConstantsSortedByType
{
    public const int ZULU = 1;

    public const string ALPHA = 'a';
}

class TypedConstants
{
    final public const ?string ZULU = null;

    public const \Foo\Bar YANKEE = \Foo\Bar::Baz;

    const int|string ALPHA = 1;

    protected const Foo&Bar XRAY = Foo::Xray;

    private const (Foo&Bar)|null BRAVO = null;
}

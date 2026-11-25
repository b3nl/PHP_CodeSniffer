<?php

namespace Test;

class MembersAfterNestedScopes
{
    public function __construct($parameter)
    {
    }

    public function alpha(): void
    {
    }

    private $alpha;

    private $zulu;

    public function zulu(): object
    {
        $zulu = 1;

        return new class {
            public $aaa;

            public function aaa()
            {
            }
        };
    }
}

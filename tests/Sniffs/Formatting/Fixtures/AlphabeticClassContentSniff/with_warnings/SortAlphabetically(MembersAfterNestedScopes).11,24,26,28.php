<?php

namespace Test;

class MembersAfterNestedScopes
{
    public function __construct($parameter)
    {
    }

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

    private $zulu;

    private $alpha;

    public function alpha(): void
    {
    }
}

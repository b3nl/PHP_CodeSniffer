<?php

namespace Test;

class PropertyHooks
{
    public string $alpha = 'a' {
        set(string $value) {
            $this->alpha = $value;
        }
    }

    public string $zulu {
        get => 'z';
    }
}

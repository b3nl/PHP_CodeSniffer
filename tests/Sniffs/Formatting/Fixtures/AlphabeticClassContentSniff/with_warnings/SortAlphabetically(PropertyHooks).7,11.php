<?php

namespace Test;

class PropertyHooks
{
    public string $zulu {
        get => 'z';
    }

    public string $alpha = 'a' {
        set(string $value) {
            $this->alpha = $value;
        }
    }
}

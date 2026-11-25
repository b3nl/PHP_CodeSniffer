<?php

namespace Test;

class SuppressedMember
{
    public function zulu(): void
    {
    }

    public function alpha(): void // phpcs:ignore BestIt.Formatting.AlphabeticClassContent.SortAlphabetically
    {
    }
}

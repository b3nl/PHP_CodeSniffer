<?php

namespace Test;

class CommentsNextToUnmovedMembers
{
    // This comment stays above alpha().
    public function alpha(): void
    {
    } // Trailing comment of alpha().

    public function mike(): void
    {
    }

    public function zulu(): void
    {
    }
}

<?php

declare(strict_types=1);

namespace BestIt\Sniffs\Spacing;

use SlevomatCodingStandard\Sniffs\Namespaces\UseSpacingSniff as BaseSniff;

/**
 * Forces just one line before and one line after the usages, and one line between different use types.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\Sniffs\Spacing
 */
class UseSpacingSniff extends BaseSniff
{
    /**
     * Require one blank line between different use types (class/function/const) to comply with PSR-12.
     */
    public int $linesCountBetweenUseTypes = 1;
}

<?php

declare(strict_types=1);

namespace BestIt\CodeSniffer\Helper;

use SlevomatCodingStandard\Helpers\TokenHelper as BaseHelper;

/**
 * Proxies the slevomat class to get larger compatibility with older versions.
 *
 * @author blange <bjoern.lange@bestit-online.de>
 * @package BestIt\CodeSniffer\Helper
 */
class TokenHelper extends BaseHelper
{
    public const ARRAY_TOKEN_CODES = [
        T_ARRAY,
        T_OPEN_SHORT_ARRAY,
    ];
}

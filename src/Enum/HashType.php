<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Enum;

/**
 *
 */
enum HashType: string
{
    case MD5 = 'md5';

    case RIPEMD160 = 'ripemd160';

    case SHA1 = 'sha1';

    case SHA256 = 'sha256';

    case SHA384 = 'sha384';

    case SHA512 = 'sha512';
}

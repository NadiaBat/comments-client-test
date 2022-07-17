<?php

declare(strict_types=1);

namespace Comments\Enums;

use Ergebnis\Http\Method;
use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 */
class CommentsHttpMethodsEnum extends Enum
{
    /** @var string */
    public const GET = Method::GET;

    /** @var string */
    public const POST = Method::POST;

    /** @var string */
    public const PUT = Method::PUT;
}

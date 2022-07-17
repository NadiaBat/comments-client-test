<?php

declare(strict_types=1);

namespace Comments\Requests;

use Comments\Enums\CommentsHttpMethodsEnum;

abstract class CommentsRequestAbstract
{
    /**
     * @return CommentsHttpMethodsEnum
     */
    abstract public function getMethod(): CommentsHttpMethodsEnum;

    /**
     * @return string
     */
    abstract public function getPath(): string;

    /**
     * @return array
     */
    abstract public function getQuery(): array;

    /**
     * @return array
     */
    abstract public function getBody(): array;
}

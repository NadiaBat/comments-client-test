<?php

declare(strict_types=1);

namespace Comments\Requests;

use Comments\Enums\CommentsHttpMethodsEnum;

class PostCommentRequest extends CommentsRequestAbstract
{
    /**
     * @var string
     */
    private const PATH = '/comment';

    /**
     * @param string $name
     * @param string $text
     */
    public function __construct(private string $name, private string $text)
    {
    }

    /**
     * @return CommentsHttpMethodsEnum
     */
    public function getMethod(): CommentsHttpMethodsEnum
    {
        return new CommentsHttpMethodsEnum(CommentsHttpMethodsEnum::POST);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return self::PATH;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return [
            'name' => $this->name,
            'text' => $this->text,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Comments\Requests;

use Comments\Enums\CommentsHttpMethodsEnum;

class GetCommentsRequest extends CommentsRequestAbstract
{
    /**
     * @var string
     */
    private const PATH = '/comments';

    /**
     * @param int $limit
     * @param int|null $offset
     */
    public function __construct(private int $limit, private ?int $offset = null)
    {
    }

    /**
     * @return CommentsHttpMethodsEnum
     */
    public function getMethod(): CommentsHttpMethodsEnum
    {
        return new CommentsHttpMethodsEnum(CommentsHttpMethodsEnum::GET);
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
        $result = ['limit' => $this->limit];

        if ($this->offset !== null) {
            $result['offset'] = $this->offset;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace Comments\Requests;

use Comments\Enums\CommentsHttpMethodsEnum;
use InvalidArgumentException;

class PutCommentRequest extends CommentsRequestAbstract
{
    /**
     * @var string
     */
    private const PATH = '/comment/%d';

    /**
     * @param int $ID
     * @param string|null $name
     * @param string|null $text
     * @throws InvalidArgumentException
     */
    public function __construct(
        private int $ID,
        private ?string $name = null,
        private ?string $text = null
    ) {

        if ($name === null && $text === null) {
            throw new InvalidArgumentException(
                'Для изменения комментария необходимо задать одно из полей: name, text'
            );
        }
    }

    /**
     * @return CommentsHttpMethodsEnum
     */
    public function getMethod(): CommentsHttpMethodsEnum
    {
        return new CommentsHttpMethodsEnum(CommentsHttpMethodsEnum::PUT);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return sprintf(self::PATH, $this->ID);
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
        $result = [];

        if ($this->name !== null) {
            $result['name'] = $this->name;
        }

        if ($this->text !== null) {
            $result['text'] = $this->text;
        }

        return $result;
    }
}

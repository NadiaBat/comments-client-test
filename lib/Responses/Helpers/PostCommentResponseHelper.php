<?php

declare(strict_types=1);

namespace Comments\Responses\Helpers;

use Comments\Responses\PostCommentResponse;
use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

class PostCommentResponseHelper
{
    /**
     * @var string
     */
    private const ERROR = 'Не удалось создать ответ для добавления комментария';

    /**
     * @param ResponseInterface $response
     * @return PostCommentResponse
     * @throws UnexpectedValueException
     */
    public static function createFromPsrResponse(ResponseInterface $response): PostCommentResponse
    {
        try {
            $body = ResponseBodyHelper::getFromPsrResponse($response);
        } catch (UnexpectedValueException $e) {
            throw new UnexpectedValueException(
                self::ERROR,
                0,
                $e
            );
        }

        try {
            return new PostCommentResponse(CommentEntityHelper::createFromApi($body));
        } catch (UnexpectedValueException $e) {
            throw new UnexpectedValueException(
                self::ERROR,
                0,
                $e
            );
        }
    }
}

<?php

declare(strict_types=1);

namespace Comments\Responses\Helpers;

use Comments\Responses\GetCommentsResponse;
use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

class GetCommentsResponseHelper
{
    /**
     * @var string
     */
    private const ERROR = 'Не удалось создать ответ для списка комментариев';

    /**
     * @param ResponseInterface $response
     * @return GetCommentsResponse
     * @throws UnexpectedValueException
     */
    public static function createFromPsrResponse(ResponseInterface $response): GetCommentsResponse
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
            return new GetCommentsResponse(
                CommentsCollectionHelper::createFromApi(self::getArray($body, 'data')),
                GetCommentsMetaResponseHelper::createFromApi(self::getArray($body, 'meta'))
            );
        } catch (UnexpectedValueException $e) {
            throw new UnexpectedValueException(
                self::ERROR,
                0,
                $e
            );
        }
    }

    /**
     * @param array $body
     * @param string $field
     * @return array
     * @throws UnexpectedValueException
     */
    private static function getArray(array $body, string $field): array
    {
        try {
            return TypesHelper::getArrayFromArray($body, $field);
        }  catch (UnexpectedValueException $e) {
            throw new UnexpectedValueException(
                sprintf(
                    'Не удалось получить поле %s из ответа для списка комментариев',
                    $field
                ),
                0,
                $e
            );
        }
    }
}

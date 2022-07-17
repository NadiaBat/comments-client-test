<?php

declare(strict_types=1);

namespace Comments\Responses\Helpers;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Safe\Exceptions\JsonException;
use UnexpectedValueException;
use function Safe\json_decode as safe_json_decode;

class ResponseBodyHelper
{
    /**
     * @var string
     */
    private const ERROR = 'Не удалось получить тело ответа';

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getFromPsrResponse(ResponseInterface $response): array
    {
        try {
            $body = $response->getBody()->getContents();
        } catch (RuntimeException $e) {
            throw new UnexpectedValueException(self::ERROR, 0, $e);
        }

        if (empty($body)) {
            return [];
        }

        try {
            return safe_json_decode($body, true);
        } catch (JsonException $e) {
            throw new UnexpectedValueException(self::ERROR, 0, $e);
        }
    }
}

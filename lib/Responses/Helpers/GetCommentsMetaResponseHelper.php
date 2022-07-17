<?php

declare(strict_types=1);

namespace Comments\Responses\Helpers;

use Comments\Responses\MetaResponse;
use UnexpectedValueException;

class GetCommentsMetaResponseHelper
{
    /**
     * @param array $meta
     * @return MetaResponse
     * @throws UnexpectedValueException
     */
    public static function createFromApi(array $meta): MetaResponse
    {
        try {
            return new MetaResponse(
                TypesHelper::getIntFromArray($meta, 'total')
            );
        } catch (UnexpectedValueException $e) {
            throw new UnexpectedValueException(
                'Не удалось создать meta из ответа api',
                0,
                $e
            );
        }
    }
}

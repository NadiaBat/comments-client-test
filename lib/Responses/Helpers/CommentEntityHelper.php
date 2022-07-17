<?php

declare(strict_types=1);

namespace Comments\Responses\Helpers;

use Comments\Entities\CommentEntity;
use UnexpectedValueException;

class CommentEntityHelper
{
    /**
     * @param array $comment
     * @return CommentEntity
     * @throws UnexpectedValueException
     */
    public static function createFromApi(array $comment): CommentEntity
    {
        try {
            return new CommentEntity(
                TypesHelper::getIntFromArray($comment, 'ID'),
                TypesHelper::getStringFromArray($comment, 'name'),
                TypesHelper::getStringFromArray($comment, 'text')
            );
        } catch (UnexpectedValueException $e) {
            throw new UnexpectedValueException(
                'Не удалось создать комментарий из ответа api',
                0,
                $e
            );
        }
    }
}

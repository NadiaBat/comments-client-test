<?php

declare(strict_types=1);

namespace Comments\Responses\Helpers;

use Comments\Collections\CommentsCollection;
use UnexpectedValueException;

class CommentsCollectionHelper
{
    /**
     * @param array $comments
     * @return CommentsCollection
     * @throws UnexpectedValueException
     */
    public static function createFromApi(array $comments): CommentsCollection
    {
        $result = new CommentsCollection();

        foreach ($comments as $comment) {
            try {
                $result->add(CommentEntityHelper::createFromApi($comment));
            } catch (UnexpectedValueException $e) {
                throw new UnexpectedValueException(
                    'Не удалось создать коллекцию комментариев из ответа api',
                    0,
                    $e
                );
            }
        }

        return $result;
    }
}

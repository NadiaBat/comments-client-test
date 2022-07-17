<?php

declare(strict_types=1);

namespace Comments\Collections;

use Comments\Entities\CommentEntity;
use Ramsey\Collection\AbstractCollection;

class CommentsCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return CommentEntity::class;
    }
}

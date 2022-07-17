<?php

declare(strict_types=1);

namespace Comments\Responses;

use Comments\Entities\CommentEntity;

class PostCommentResponse
{
    /**
     * @param CommentEntity $comment
     */
    public function __construct(private CommentEntity $comment)
    {
    }

    /**
     * @return CommentEntity
     */
    public function getComment(): CommentEntity
    {
        return $this->comment;
    }
}

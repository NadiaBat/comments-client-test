<?php

declare(strict_types=1);

namespace Comments\Responses;

use Comments\Collections\CommentsCollection;

class GetCommentsResponse
{
    /**
     * @param CommentsCollection $comments
     * @param MetaResponse $meta
     */
    public function __construct(private CommentsCollection $comments, private MetaResponse $meta)
    {
    }

    /**
     * @return CommentsCollection
     */
    public function getComments(): CommentsCollection
    {
        return $this->comments;
    }

    /**
     * @return MetaResponse
     */
    public function getMeta(): MetaResponse
    {
        return $this->meta;
    }
}

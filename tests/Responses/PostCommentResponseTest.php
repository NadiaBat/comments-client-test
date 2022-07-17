<?php

declare(strict_types=1);

namespace tests\Comments\Responses;

use Comments\Entities\CommentEntity;
use Comments\Responses\PostCommentResponse;
use PHPUnit\Framework\TestCase;

class PostCommentResponseTest extends TestCase
{
    public function testGetters(): void
    {
        $comment = new CommentEntity(10, 'name', 'text');
        $response = new PostCommentResponse($comment);

        self::assertEquals($comment, $response->getComment());
    }
}

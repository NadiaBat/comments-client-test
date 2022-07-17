<?php

declare(strict_types=1);

namespace tests\Comments\Responses;

use Comments\Collections\CommentsCollection;
use Comments\Responses\GetCommentsResponse;
use Comments\Responses\MetaResponse;
use PHPUnit\Framework\TestCase;

class GetCommentsResponseTest extends TestCase
{
    public function testGetters(): void
    {
        $comments = new CommentsCollection();
        $meta = new MetaResponse(10);

        $response = new GetCommentsResponse($comments, $meta);

        self::assertEquals($comments, $response->getComments());
        self::assertEquals($meta, $response->getMeta());
    }
}

<?php

declare(strict_types=1);

namespace tests\Comments\Requests;

use Comments\Enums\CommentsHttpMethodsEnum;
use Comments\Requests\PostCommentRequest;
use PHPUnit\Framework\TestCase;

class PostCommentsRequestTest extends TestCase
{
    public function testGetters(): void
    {
        $name = 'name';
        $text = 'text';

        $request = new PostCommentRequest($name, $text);

        self::assertEquals(new CommentsHttpMethodsEnum('POST'), $request->getMethod());
        self::assertEquals('/comment', $request->getPath());
        self::assertEquals([], $request->getQuery());
        self::assertEquals(['name' => $name, 'text' => $text], $request->getBody());
    }
}

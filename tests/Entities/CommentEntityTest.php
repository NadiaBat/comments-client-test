<?php

declare(strict_types=1);

namespace tests\Comments\Entities;

use Comments\Entities\CommentEntity;
use PHPUnit\Framework\TestCase;

class CommentEntityTest extends TestCase
{
    public function testGetters(): void
    {
        $ID = 100;
        $name = 'name';
        $text = 'text';

        $comment = new CommentEntity($ID, $name, $text);

        self::assertEquals($ID, $comment->getID());
        self::assertEquals($name, $comment->getName());
        self::assertEquals($text, $comment->getText());
    }
}

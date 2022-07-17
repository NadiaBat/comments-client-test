<?php

declare(strict_types=1);

namespace tests\Comments\Responses\Helpers;

use Comments\Collections\CommentsCollection;
use Comments\Entities\CommentEntity;
use Comments\Responses\Helpers\CommentsCollectionHelper;
use Generator;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class CommentsCollectionHelperTest extends TestCase
{
    /**
     * @param array $comments
     * @param CommentsCollection $expected
     * @dataProvider createFromApiSucceedDataProvider
     */
    public function testCreateFromApiSucceed(
        array $comments,
        CommentsCollection $expected
    ): void {

        self::assertEquals($expected, CommentsCollectionHelper::createFromApi($comments));
    }

    /**
     * @return Generator
     */
    public function createFromApiSucceedDataProvider(): Generator
    {
        yield 'not empty' => [
            'comments' => [['ID' => 10, 'name' => 'name', 'text' => 'text']],
            'expected' => new CommentsCollection([new CommentEntity(10, 'name', 'text')]),
        ];

        yield 'empty' => [
            'comments' => [],
            'expected' => new CommentsCollection(),
        ];
    }

    /**
     * @param array $comment
     * @dataProvider createFromApiFailedDataProvider
     */
    public function testCreateFromApiFailed(
        array $comment
    ): void {

        $this->expectException(UnexpectedValueException::class);

        CommentsCollectionHelper::createFromApi($comment);
    }

    /**
     * @return Generator
     */
    public function createFromApiFailedDataProvider(): Generator
    {
        yield 'invalid ID' => [
            [['ID' => 'abc', 'name' => 'name', 'text' => 'text']],
        ];

        yield 'ID does not exist' => [
            [['ID' => 'abc', 'name' => 'name', 'text' => 'text']],
        ];

        yield 'invalid name' => [
            [['ID' => 10, 'name' => 100, 'text' => 'text']],
        ];

        yield 'name does not exist' => [
            [['ID' => 10, 'text' => 'text']],
        ];

        yield 'invalid text' => [
            [['ID' => 10, 'name' => 'name', 'text' => 100]],
        ];

        yield 'text does not exist' => [
            [['ID' => 10, 'name' => 'name']],
        ];
    }
}

<?php

declare(strict_types=1);

namespace tests\Comments\Responses\Helpers;

use Comments\Entities\CommentEntity;
use Comments\Responses\Helpers\CommentEntityHelper;
use Generator;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class CommentEntityHelperTest extends TestCase
{
    public function testCreateFromApiSucceed(): void
    {
        self::assertEquals(
            new CommentEntity(10, 'name', 'text'),
            CommentEntityHelper::createFromApi(['ID' => 10, 'name' => 'name', 'text' => 'text'])
        );
    }

    /**
     * @param array $comment
     * @dataProvider createFromApiFailedDataProvider
     */
    public function testCreateFromApiFailed(
        array $comment
    ): void {

        $this->expectException(UnexpectedValueException::class);

        CommentEntityHelper::createFromApi($comment);
    }

    /**
     * @return Generator
     */
    public function createFromApiFailedDataProvider(): Generator
    {
        yield 'invalid ID' => [
            ['ID' => 'abc', 'name' => 'name', 'text' => 'text'],
        ];

        yield 'ID does not exist' => [
            ['ID' => 'abc', 'name' => 'name', 'text' => 'text'],
        ];

        yield 'invalid name' => [
            ['ID' => 10, 'name' => 100, 'text' => 'text'],
        ];

        yield 'name does not exist' => [
            ['ID' => 10, 'text' => 'text'],
        ];

        yield 'invalid text' => [
            ['ID' => 10, 'name' => 'name', 'text' => 100],
        ];

        yield 'text does not exist' => [
            ['ID' => 10, 'name' => 'name'],
        ];
    }
}

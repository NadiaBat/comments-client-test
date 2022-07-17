<?php

declare(strict_types=1);

namespace tests\Comments\Requests;

use Comments\Enums\CommentsHttpMethodsEnum;
use Comments\Requests\GetCommentsRequest;
use Comments\Requests\PutCommentRequest;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PutCommentsRequestTest extends TestCase
{
    /**
     * @param int $ID
     * @param string|null $name
     * @param string|null $text
     * @param CommentsHttpMethodsEnum $expectedMethod
     * @param string $expectedPath
     * @param array $expectedQuery
     * @param array $expectedBody
     * @dataProvider gettersSucceedDataProvider
     */
    public function testGettersSucceed(
        int $ID,
        ?string $name,
        ?string $text,
        CommentsHttpMethodsEnum $expectedMethod,
        string $expectedPath,
        array $expectedQuery,
        array $expectedBody
    ): void {

        $request = new PutCommentRequest($ID, $name, $text);

        self::assertEquals($expectedMethod, $request->getMethod());
        self::assertEquals($expectedPath, $request->getPath());
        self::assertEquals($expectedQuery, $request->getQuery());
        self::assertEquals($expectedBody, $request->getBody());
    }

    /**
     * @return Generator
     */
    public function gettersSucceedDataProvider(): Generator
    {
        yield 'all fields' => [
            'ID' => 10,
            'name' => 'name',
            'text' => 'text',
            'expectedMethod' => new CommentsHttpMethodsEnum('PUT'),
            'expectedPath' => '/comment/10',
            'expectedQuery' => [],
            'expectedBody' => ['name' => 'name', 'text' => 'text'],
        ];

        yield 'text is null' => [
            'ID' => 10,
            'name' => 'name',
            'text' => null,
            'expectedMethod' => new CommentsHttpMethodsEnum('PUT'),
            'expectedPath' => '/comment/10',
            'expectedQuery' => [],
            'expectedBody' => ['name' => 'name'],
        ];

        yield 'name is null' => [
            'ID' => 10,
            'name' => null,
            'text' => 'text',
            'expectedMethod' => new CommentsHttpMethodsEnum('PUT'),
            'expectedPath' => '/comment/10',
            'expectedQuery' => [],
            'expectedBody' => ['text' => 'text'],
        ];
    }

    public function testCreateFailed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PutCommentRequest(10, null, null);
    }
}

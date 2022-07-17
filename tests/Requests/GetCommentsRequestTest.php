<?php

declare(strict_types=1);

namespace tests\Comments\Requests;

use Comments\Enums\CommentsHttpMethodsEnum;
use Comments\Requests\GetCommentsRequest;
use Generator;
use PHPUnit\Framework\TestCase;

class GetCommentsRequestTest extends TestCase
{
    /**
     * @param int $limit
     * @param int|null $offset
     * @param CommentsHttpMethodsEnum $expectedMethod
     * @param string $expectedPath
     * @param array $expectedQuery
     * @param array $expectedBody
     * @dataProvider gettersDataProvider
     */
    public function testGetters(
        int $limit,
        ?int $offset,
        CommentsHttpMethodsEnum $expectedMethod,
        string $expectedPath,
        array $expectedQuery,
        array $expectedBody
    ): void {

        $request = new GetCommentsRequest($limit, $offset);

        self::assertEquals($expectedMethod, $request->getMethod());
        self::assertEquals($expectedPath, $request->getPath());
        self::assertEquals($expectedQuery, $request->getQuery());
        self::assertEquals($expectedBody, $request->getBody());
    }

    /**
     * @return Generator
     */
    public function gettersDataProvider(): Generator
    {
        yield 'offset is not null' => [
            'limit' => 10,
            'offset' => 2,
            'expectedMethod' => new CommentsHttpMethodsEnum('GET'),
            'expectedPath' => '/comments',
            'expectedQuery' => ['limit' => 10, 'offset' => 2],
            'expectedBody' => [],
        ];

        yield 'offset is null' => [
            'limit' => 10,
            'offset' => null,
            'expectedMethod' => new CommentsHttpMethodsEnum('GET'),
            'expectedPath' => '/comments',
            'expectedQuery' => ['limit' => 10],
            'expectedBody' => [],
        ];
    }
}

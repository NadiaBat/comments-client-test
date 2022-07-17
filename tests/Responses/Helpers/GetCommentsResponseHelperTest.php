<?php

declare(strict_types=1);

namespace tests\Comments\Responses\Helpers;

use Comments\Collections\CommentsCollection;
use Comments\Entities\CommentEntity;
use Comments\Responses\GetCommentsResponse;
use Comments\Responses\Helpers\GetCommentsResponseHelper;
use Comments\Responses\MetaResponse;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use UnexpectedValueException;

class GetCommentsResponseHelperTest extends TestCase
{
    /**
     * @var ResponseInterface|MockObject
     */
    private ResponseInterface|MockObject $response;

    /**
     * @var MockObject|StreamInterface
     */
    private MockObject|StreamInterface $body;

    public function setUp(): void
    {
        $this->response = $this->createMock(ResponseInterface::class);
        $this->body = $this->createMock(StreamInterface::class);
        $this->response->method('getBody')->willReturn($this->body);
    }

    /**
     * @param array $body
     * @param GetCommentsResponse $expected
     * @dataProvider createFromResponseSucceedDataProvider
     */
    public function testCreateFromResponseSucceed(
        array $body,
        GetCommentsResponse $expected
    ): void {

        $this->body->method('getContents')->willReturn(json_encode($body));

        self::assertEquals(
            $expected,
            GetCommentsResponseHelper::createFromPsrResponse($this->response)
        );
    }

    /**
     * @return Generator
     */
    public function createFromResponseSucceedDataProvider(): Generator
    {
        yield 'not empty' => [
            'body' => [
                'data' => [['ID' => 10, 'name' => 'name', 'text' => 'text']],
                'meta' => ['total' => 20]
            ],
            'expected' => new GetCommentsResponse(
                new CommentsCollection([
                    new CommentEntity(10, 'name', 'text')
                ]),
                new MetaResponse(20)
            )
        ];

        yield 'is empty' => [
            'body' => [
                'data' => [],
                'meta' => ['total' => 0]
            ],
            'expected' => new GetCommentsResponse(
                new CommentsCollection(),
                new MetaResponse(0)
            )
        ];
    }

    /**
     * @param array $body
     * @dataProvider createFromResponseFailedDataProvider
     */
    public function testCreateFromResponseFailed(array $body): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->body->method('getContents')->willReturn(json_encode($body));
        GetCommentsResponseHelper::createFromPsrResponse($this->response);
    }

    /**
     * @return Generator
     */
    public function createFromResponseFailedDataProvider(): Generator
    {
        yield 'data is invalid' => [
            [
                'data' => 'abc',
                'meta' => ['total' => 20]
            ]
        ];

        yield 'data does not exist' => [
            [
                'meta' => ['total' => 20]
            ]
        ];

        yield 'meta is invalid' => [
            [
                'data' => [['ID' => 10, 'name' => 'name', 'text' => 'text']],
                'meta' => 'abc'
            ]
        ];

        yield 'meta does not exist' => [
            [
                'data' => [['ID' => 10, 'name' => 'name', 'text' => 'text']],
            ]
        ];
    }
}

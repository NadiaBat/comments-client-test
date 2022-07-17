<?php

declare(strict_types=1);

namespace tests\Comments\Responses\Helpers;

use Comments\Entities\CommentEntity;
use Comments\Responses\Helpers\GetCommentsResponseHelper;
use Comments\Responses\Helpers\PostCommentResponseHelper;
use Comments\Responses\PostCommentResponse;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use UnexpectedValueException;

class PostCommentResponseHelperTest extends TestCase
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
     * @param PostCommentResponse $expected
     * @dataProvider createFromResponseSucceedDataProvider
     */
    public function testCreateFromResponseSucceed(
        array $body,
        PostCommentResponse $expected
    ): void {

        $this->body->method('getContents')->willReturn(json_encode($body));

        self::assertEquals(
            $expected,
            PostCommentResponseHelper::createFromPsrResponse($this->response)
        );
    }

    /**
     * @return Generator
     */
    public function createFromResponseSucceedDataProvider(): Generator
    {
        yield 'not empty' => [
            'body' => [
                'ID' => 10, 'name' => 'name', 'text' => 'text',
            ],
            'expected' => new PostCommentResponse(
                new CommentEntity(10, 'name', 'text')
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
        yield 'ID is invalid' => [
            ['ID' => 'abc', 'name' => 'name', 'text' => 'text']
        ];

        yield 'ID does not exist' => [
            ['name' => 'name', 'text' => 'text']
        ];

        yield 'name is invalid' => [
            ['ID' => 10, 'name' => 100, 'text' => 'text']
        ];

        yield 'name does not exist' => [
            ['ID' => 10, 'text' => 'text']
        ];

        yield 'text is invalid' => [
            ['ID' => 10, 'name' => 'name', 'text' => 100]
        ];

        yield 'text does not exist' => [
            ['ID' => 10, 'name' => 'name']
        ];
    }
}

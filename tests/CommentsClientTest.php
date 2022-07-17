<?php

declare(strict_types=1);

namespace tests\Comments;

use Comments\Collections\CommentsCollection;
use Comments\CommentsClient;
use Comments\Entities\CommentEntity;
use Comments\Requests\GetCommentsRequest;
use Comments\Requests\PostCommentRequest;
use Comments\Requests\PutCommentRequest;
use Comments\Responses\GetCommentsResponse;
use Comments\Responses\MetaResponse;
use Comments\Responses\PostCommentResponse;
use HttpException\InternalServerErrorException;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use UnexpectedValueException;

class CommentsClientTest extends TestCase
{
    /**
     * @var ClientInterface|MockObject
     */
    private ClientInterface|MockObject $httpClient;

    /**
     * @var CommentsClient
     */
    private CommentsClient $commentsClient;

    /**
     * @var MockObject|StreamInterface
     */
    private MockObject|StreamInterface $responseStream;

    /**
     * @var MockObject|RequestInterface
     */
    private MockObject|RequestInterface $request;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->request->method('withBody')->willReturn($this->request);
        $requestFactory->method('createRequest')->willReturn($this->request);
        $streamFactory = $this->createMock(StreamFactoryInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $this->httpClient->method('sendRequest')->willReturn($response);

        $this->responseStream = $this->createMock(StreamInterface::class);
        $response->method('getBody')->willReturn($this->responseStream);

        $this->commentsClient = new CommentsClient(
            'abc',
            $this->httpClient,
            $requestFactory,
            $streamFactory
        );
    }

    public function testPostSucceed(): void
    {
        $this->responseStream
            ->method('getContents')
            ->willReturn(json_encode(['ID' => 10, 'name' => 'name', 'text' => 'text']));

        self::assertEquals(
            new PostCommentResponse(new CommentEntity(10, 'name', 'text')),
            $this->commentsClient->post(new PostCommentRequest('abc', 'cde'))
        );
    }

    public function testPostClientFailed(): void
    {
        $this->expectException(InternalServerErrorException::class);

        $this->httpClient
            ->method('sendRequest')
            ->willThrowException($this->createMock(ClientExceptionInterface::class));

        $this->commentsClient->post(new PostCommentRequest('abc', 'cde'));
    }

    public function testPostRequestWithBodyFailed(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->request->method('withBody')->willThrowException(new InvalidArgumentException());
        $this->commentsClient->post(new PostCommentRequest('abc', 'cde'));
    }

    public function testGetSucceed(): void
    {
        $this->responseStream
            ->method('getContents')
            ->willReturn(
                json_encode([
                    'data' => [['ID' => 10, 'name' => 'name', 'text' => 'text']],
                    'meta' => ['total' => 10]
                ])
            );

        self::assertEquals(
            new GetCommentsResponse(
                new CommentsCollection([new CommentEntity(10, 'name', 'text')]),
                new MetaResponse(10)
            ),
            $this->commentsClient->get(new GetCommentsRequest(20, 30))
        );
    }

    public function testGetClientFailed(): void
    {
        $this->expectException(InternalServerErrorException::class);

        $this->httpClient
            ->method('sendRequest')
            ->willThrowException($this->createMock(ClientExceptionInterface::class));

        $this->commentsClient->get(new GetCommentsRequest(20, 30));
    }

    public function testGetRequestWithBodyFailed(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->request->method('withBody')->willThrowException(new InvalidArgumentException());
        $this->commentsClient->get(new GetCommentsRequest(20, 30));
    }

    public function testPutSucceed(): void
    {
        $this->expectNotToPerformAssertions();

        $this->commentsClient->put(new PutCommentRequest(10, 'name', 'test'));
    }

    public function testPutClientFailed(): void
    {
        $this->expectException(InternalServerErrorException::class);

        $this->httpClient
            ->method('sendRequest')
            ->willThrowException($this->createMock(ClientExceptionInterface::class));

        $this->commentsClient->put(new PutCommentRequest(10, 'name', 'test'));
    }

    public function testPutRequestWithBodyFailed(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->request->method('withBody')->willThrowException(new InvalidArgumentException());
        $this->commentsClient->put(new PutCommentRequest(10, 'name', 'test'));
    }
}

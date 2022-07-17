<?php

declare(strict_types=1);

namespace tests\Comments\Responses\Helpers;

use Comments\Responses\Helpers\ResponseBodyHelper;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use UnexpectedValueException;

class ResponseBodyHelperTest extends TestCase
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
     * @param string $body
     * @param array $expected
     * @dataProvider getFromPsrResponseSucceedDataProvider
     */
    public function testGetFromPsrResponseSucceed(
        string $body,
        array $expected
    ): void {

        $this->body->method('getContents')->willReturn($body);

        self::assertEquals(
            $expected,
            ResponseBodyHelper::getFromPsrResponse($this->response)
        );
    }

    /**
     * @return Generator
     */
    public function getFromPsrResponseSucceedDataProvider(): Generator
    {
        yield 'not empty' => [
            '{"abc": "cde"}',
            ['abc' => 'cde']
        ];

        yield 'empty' => [
            '',
            []
        ];

        yield 'empty 2' => [
            '[]',
            []
        ];
    }

    /**
     * @param string $body
     * @throws UnexpectedValueException
     * @dataProvider getFromPsrResponseFailedDataProvider
     */
    public function testGetFromPsrResponseParseJsonFailed(string $body): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->body->method('getContents')->willReturn($body);

        ResponseBodyHelper::getFromPsrResponse($this->response);
    }

    /**
     * @return Generator
     */
    public function getFromPsrResponseFailedDataProvider(): Generator
    {
        yield 'invalid json' => [
            '{"abc": "cde}'
        ];
    }

    public function testGetFromPsrResponseGetContentsFailed(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->body->method('getContents')->willThrowException(new RuntimeException());

        ResponseBodyHelper::getFromPsrResponse($this->response);
    }
}

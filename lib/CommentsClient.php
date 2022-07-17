<?php

declare(strict_types=1);

namespace Comments;

use Comments\Requests\CommentsRequestAbstract;
use Comments\Requests\GetCommentsRequest;
use Comments\Requests\PostCommentRequest;
use Comments\Requests\PutCommentRequest;
use Comments\Responses\GetCommentsResponse;
use Comments\Responses\Helpers\GetCommentsResponseHelper;
use Comments\Responses\Helpers\PostCommentResponseHelper;
use Comments\Responses\PostCommentResponse;
use HttpException\InternalServerErrorException;
use InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Safe\Exceptions\JsonException;
use UnexpectedValueException;
use function Safe\json_encode as safe_json_encode;

class CommentsClient
{
    /**
     * @param string $baseURI
     * @param ClientInterface $client
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface $streamFactory
     */
    public function __construct(
        private string $baseURI,
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory
    ) {}

    /**
     * @param PostCommentRequest $request
     * @return PostCommentResponse
     * @throws InternalServerErrorException
     * @throws UnexpectedValueException
     */
    public function post(PostCommentRequest $request): PostCommentResponse
    {
        return PostCommentResponseHelper::createFromPsrResponse($this->send($request));
    }

    /**
     * @param PutCommentRequest $request
     * @throws InternalServerErrorException
     * @throws UnexpectedValueException
     */
    public function put(PutCommentRequest $request): void
    {
        $this->send($request);
    }

    /**
     * @param GetCommentsRequest $request
     * @return GetCommentsResponse
     * @throws InternalServerErrorException
     * @throws UnexpectedValueException
     */
    public function get(GetCommentsRequest $request): GetCommentsResponse
    {
        return GetCommentsResponseHelper::createFromPsrResponse($this->send($request));
    }

    /**
     * @param CommentsRequestAbstract $request
     * @return ResponseInterface
     * @throws UnexpectedValueException
     * @throws InternalServerErrorException
     */
    public function send(CommentsRequestAbstract $request): ResponseInterface
    {
        try {
            return $this->client->sendRequest($this->getRequest($request));
        } catch (RequestExceptionInterface | ClientExceptionInterface $e) {
            throw new InternalServerErrorException(
                'Не удалось выполнить запрос',
                0,
                $e
            );
        }
    }

    /**
     * @param CommentsRequestAbstract $request
     * @return RequestInterface
     * @throws UnexpectedValueException
     */
    private function getRequest(CommentsRequestAbstract $request): RequestInterface
    {
        $query = $request->getQuery();

        $result = $this->requestFactory->createRequest(
            $request->getMethod()->getValue(),
            $this->baseURI . $request->getPath() .
            (!empty($query) ? '?' . http_build_query($query) : '')
        );

        $requestBody = $request->getBody();

        if (empty($requestBody)) {
            return $result;
        }

        try {
            $result = $result->withBody(
                $this->streamFactory->createStream(safe_json_encode($requestBody))
            );
        } catch (JsonException | InvalidArgumentException $e) {
            throw new UnexpectedValueException(
                'Не удалось закодировать тело запроса',
                0,
                $e
            );
        }

        return $result;
    }
}

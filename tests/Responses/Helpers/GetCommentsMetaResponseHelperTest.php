<?php

declare(strict_types=1);

namespace tests\Comments\Responses\Helpers;

use Comments\Responses\Helpers\GetCommentsMetaResponseHelper;
use Comments\Responses\MetaResponse;
use Generator;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class GetCommentsMetaResponseHelperTest extends TestCase
{
    public function testCreateFromApiSucceed(): void
    {
        self::assertEquals(
            new MetaResponse(10),
            GetCommentsMetaResponseHelper::createFromApi(['total' => 10])
        );
    }

    /**
     * @param array $meta
     * @dataProvider createFormApiFailedDataProvider
     */
    public function testCreateFromApiFailed(array $meta): void
    {
        $this->expectException(UnexpectedValueException::class);

        GetCommentsMetaResponseHelper::createFromApi($meta);
    }

    /**
     * @return Generator
     */
    public function createFormApiFailedDataProvider(): Generator
    {
        yield 'total is invalid' => [
            ['total' => 'abc']
        ];

        yield 'total does not exist' => [
            []
        ];
    }
}

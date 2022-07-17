<?php

declare(strict_types=1);

namespace tests\Comments\Responses;

use Comments\Responses\MetaResponse;
use PHPUnit\Framework\TestCase;

class MetaResponseTest extends TestCase
{
    public function testGetters(): void
    {
        $total = 10;
        $response = new MetaResponse($total);

        self::assertEquals($total, $response->getTotal());
    }
}

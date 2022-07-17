<?php

declare(strict_types=1);

namespace tests\Comments\Responses\Helpers;

use Comments\Responses\Helpers\TypesHelper;
use Generator;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class TypesHelperTest extends TestCase
{
    public function testGetIntFromArraySucceed(): void
    {
        self::assertEquals(
            10,
            TypesHelper::getIntFromArray(
                ['field' => 10],
                'field'
            )
        );
    }

    /**
     * @param array $data
     * @param string $field
     * @dataProvider getIntFromArrayFailedDataProvider
     */
    public function testGetIntFromArrayFailed(array $data, string $field): void
    {
        $this->expectException(UnexpectedValueException::class);
        TypesHelper::getIntFromArray($data, $field);
    }

    /**
     * @return Generator
     */
    public function getIntFromArrayFailedDataProvider(): Generator
    {
        yield 'field does not exist' => [
            'data' => [],
            'field' => 'abc'
        ];

        yield 'field is invalid' => [
            'data' => ['abc' => 'cde'],
            'field' => 'abc'
        ];
    }

    public function testGetStringFromArraySucceed(): void
    {
        self::assertEquals(
            'abc',
            TypesHelper::getStringFromArray(
                ['field' => 'abc'],
                'field'
            )
        );
    }

    /**
     * @param array $data
     * @param string $field
     * @dataProvider getStringFromArrayFailedDataProvider
     */
    public function testGetStringFromArrayFailed(array $data, string $field): void
    {
        $this->expectException(UnexpectedValueException::class);
        TypesHelper::getStringFromArray($data, $field);
    }

    /**
     * @return Generator
     */
    public function getStringFromArrayFailedDataProvider(): Generator
    {
        yield 'field does not exist' => [
            'data' => [],
            'field' => 'abc'
        ];

        yield 'field is invalid' => [
            'data' => ['abc' => 10],
            'field' => 'abc'
        ];
    }

    public function testGetArrayFromArraySucceed(): void
    {
        self::assertEquals(
            ['abc'],
            TypesHelper::getArrayFromArray(
                ['field' => ['abc']],
                'field'
            )
        );
    }

    /**
     * @param array $data
     * @param string $field
     * @dataProvider getArrayFromArrayFailedDataProvider
     */
    public function testGetArrayFromArrayFailed(array $data, string $field): void
    {
        $this->expectException(UnexpectedValueException::class);
        TypesHelper::getArrayFromArray($data, $field);
    }

    /**
     * @return Generator
     */
    public function getArrayFromArrayFailedDataProvider(): Generator
    {
        yield 'field does not exist' => [
            'data' => [],
            'field' => 'abc'
        ];

        yield 'field is invalid' => [
            'data' => ['abc' => 10],
            'field' => 'abc'
        ];
    }
}

<?php

declare(strict_types=1);

namespace Comments\Responses\Helpers;

use UnexpectedValueException;

class TypesHelper
{
    /**
     * @param array $data
     * @param string $name
     * @return int
     * @throws UnexpectedValueException
     */
    public static function getIntFromArray(array $data, string $name): int
    {
        if (!array_key_exists($name, $data) || !is_int($data[$name])) {
            throw new UnexpectedValueException(sprintf('Поле %s должно быть int', $name));
        }

        return $data[$name];
    }

    /**
     * @param array $data
     * @param string $name
     * @return string
     * @throws UnexpectedValueException
     */
    public static function getStringFromArray(array $data, string $name): string
    {
        if (!array_key_exists($name, $data) || !is_string($data[$name])) {
            throw new UnexpectedValueException(sprintf('Поле %s должно быть string', $name));
        }

        return $data[$name];
    }

    /**
     * @param array $data
     * @param string $name
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getArrayFromArray(array $data, string $name): array
    {
        if (!array_key_exists($name, $data) || !is_array($data[$name])) {
            throw new UnexpectedValueException(sprintf('Поле %s должно быть array', $name));
        }

        return $data[$name];
    }
}

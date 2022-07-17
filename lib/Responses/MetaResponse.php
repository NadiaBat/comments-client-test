<?php

declare(strict_types=1);

namespace Comments\Responses;

class MetaResponse
{
    /**
     * @param int $total
     */
    public function __construct(private int $total)
    {
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}

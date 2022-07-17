<?php

declare(strict_types=1);

namespace Comments\Entities;

class CommentEntity
{
    /**
     * @param int $ID
     * @param string $name
     * @param string $text
     */
    public function __construct(private int $ID, private string $name, private string $text)
    {
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}

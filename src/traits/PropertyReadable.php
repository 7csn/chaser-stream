<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 属性可读
 *
 * @package chaser\stream\traits
 */
trait PropertyReadable
{
    /**
     * 属性可读
     *
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->{$name} ?? null;
    }
}

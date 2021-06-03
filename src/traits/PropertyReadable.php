<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 属性可读特征
 *
 * @package chaser\stream\traits
 */
trait PropertyReadable
{
    /**
     * 属性可读
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->{$name} ?? null;
    }
}

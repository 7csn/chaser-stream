<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 资源流上下文
 *
 * @package chaser\stream\traits
 */
trait Context
{
    /**
     * @inheritDoc
     */
    public function contextualize(array $options)
    {
        $this->contextOptions = array_merge_recursive($this->contextOptions, $options);
    }
}

<?php

namespace chaser\stream\traits;

use chaser\stream\interfaces\parts\ContextInterface;

/**
 * 流资源上下文特征
 *
 * @package chaser\stream\traits
 *
 * @property array $contextOptions
 *
 * @see ContextInterface
 */
trait Context
{
    /**
     * @inheritDoc
     */
    public function contextualize(array $options): void
    {
        $this->contextOptions = array_merge_recursive($this->contextOptions, $options);
    }
}

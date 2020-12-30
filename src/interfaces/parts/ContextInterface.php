<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 资源流上下文
 *
 * @package chaser\stream\interfaces\parts
 */
interface ContextInterface
{
    /**
     * 资源流上下文配置
     *
     * @param array $options
     */
    public function contextualize(array $options);
}

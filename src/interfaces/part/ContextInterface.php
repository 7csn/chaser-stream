<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\part;

/**
 * 流资源上下文部分接口
 *
 * @package chaser\stream\interfaces\part
 */
interface ContextInterface
{
    /**
     * 资源流上下文配置
     *
     * @param array $options
     */
    public function contextualize(array $options): void;
}

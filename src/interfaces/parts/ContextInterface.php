<?php

namespace chaser\stream\interfaces\parts;

/**
 * 流资源上下文部分接口
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
    public function contextualize(array $options): void;
}

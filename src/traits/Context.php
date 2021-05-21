<?php

namespace chaser\stream\traits;

use chaser\stream\interfaces\parts\ContextInterface;

/**
 * 流资源上下文特征
 *
 * @package chaser\stream\traits
 *
 * @see ContextInterface
 */
trait Context
{
    /**
     * 资源流上下文配置
     *
     * @var array[]
     */
    protected array $contextOptions = [];

    /**
     * @inheritDoc
     */
    public function contextualize(array $options): void
    {
        $this->contextOptions = array_merge_recursive($this->contextOptions, $options);
    }

    /**
     * 获取绑定上下文
     *
     * @return resource|null
     */
    protected function getContext()
    {
        return empty($this->contextOptions) ? null : stream_context_create($this->contextOptions);
    }
}

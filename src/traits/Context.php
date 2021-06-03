<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\interfaces\part\ContextInterface;

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
        $options = $this->getContextOptions();
        return empty($options) ? null : stream_context_create($options);
    }

    /**
     * 获取绑定上下文配置
     *
     * @return array
     */
    protected function getContextOptions(): array
    {
        if (!empty($this->context)) {
            $this->contextualize($this->context);
            $this->configure(['context' => []]);
        }

        return $this->contextOptions;
    }
}

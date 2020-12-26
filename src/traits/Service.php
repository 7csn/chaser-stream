<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 流服务
 *
 * @package chaser\stream\traits
 */
trait Service
{
    /**
     * 上下文绑定配置
     *
     * @var array[]
     */
    protected array $contextOptions = [];

    /**
     * 获取监听地址
     *
     * @return string
     */
    public function socketAddress(): string
    {
        return static::transport() . '://' . $this->target();
    }

    /**
     * @inheritDoc
     */
    public function contextualize(array $options)
    {
        $this->contextOptions = array_merge_recursive($this->contextOptions, $options);
    }
}

<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 配置
 *
 * @package chaser\stream\interfaces\parts
 */
interface ConfigurationInterface
{
    /**
     * 批量配置选项
     *
     * @param array $options
     */
    public function set(array $options);
}

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

    /**
     * 以属性方式设置配置项
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value);

    /**
     * 以属性方式获取配置项
     *
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name);
}

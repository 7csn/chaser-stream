<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 助手（配置、事件调度、套接字流）
 *
 * @package chaser\stream\interfaces\parts
 */
interface HelperInterface
{
    /**
     * 批量配置选项
     *
     * @param array $options
     */
    public function set(array $options);

    /**
     * 有效订阅者类型
     *
     * @return string
     */
    public static function subscriber(): string;

    /**
     * 添加订阅者
     *
     * @param string $class
     * @return bool
     */
    public function addSubscriber(string $class): bool;

    /**
     * 套接字是否失效
     *
     * @return bool
     */
    public function invalid(): bool;
}

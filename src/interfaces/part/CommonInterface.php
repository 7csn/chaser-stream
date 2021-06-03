<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\part;

/**
 * 公共部分接口（属性配置、事件调度、套接字流）
 *
 * @package chaser\stream\interfaces\part
 */
interface CommonInterface
{
    /**
     * 返回初始配置属性数组
     *
     * @return array
     */
    public static function configurations(): array;

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
     * 批量配置属性
     *
     * @param array $options
     */
    public function configure(array $options): void;

    /**
     * 套接字是否失效
     *
     * @return bool
     */
    public function invalid(): bool;
}

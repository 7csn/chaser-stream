<?php

namespace chaser\stream\interfaces\parts;

/**
 * 公共部分接口（事件调度、属性配置、套接字流）
 *
 * @package chaser\stream\interfaces\parts
 */
interface CommonInterface
{
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

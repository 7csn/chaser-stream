<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 事件触发器
 *
 * @package chaser\stream\interfaces\parts
 */
interface EventInterface
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
}

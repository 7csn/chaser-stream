<?php

namespace chaser\stream\interfaces;

use chaser\event\SubscriberInterface as BaseSubscriberInterface;

/**
 * 流服务订阅接口
 *
 * @package chaser\stream\interfaces
 */
interface SubscriberInterface extends BaseSubscriberInterface
{
    /**
     * 返回事件响应对照表
     *
     * @return string[]
     */
    public static function events(): array;
}

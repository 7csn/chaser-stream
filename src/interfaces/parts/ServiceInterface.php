<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 流服务
 *
 * @package chaser\stream\interfaces\parts
 */
interface ServiceInterface
{
    /**
     * 传输协议
     *
     * @return string
     */
    public static function transport(): string;

    /**
     * 服务监听地址
     *
     * @return string
     */
    public function target(): string;
}

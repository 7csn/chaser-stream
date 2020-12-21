<?php

declare(strict_types=1);

namespace chaser\stream;

/**
 * 网络地址
 *
 * @package chaser\stream
 */
class NetworkAddress
{
    /**
     * 获取 IP
     *
     * @param string $address
     * @return false|string
     */
    public static function getIp(string $address)
    {
        return strstr($address, ':', true);
    }

    /**
     * 获取 PORT
     *
     * @param string $address
     * @return false|int
     */
    public static function getPort(string $address)
    {
        $index = strstr($address, ':');
        return $index === 0 ? false : (int)substr(strstr($address, ':'), 1);
    }

    /**
     * 是否 ipv4
     *
     * @param string $address
     * @return bool
     */
    public static function isIpV4(string $address): bool
    {
        $ip = self::getIp($address);
        return $ip && strpos($ip, ':') === false;
    }

    /**
     * 是否 ipv6
     *
     * @param string $address
     * @return bool
     */
    public static function isIpV6(string $address): bool
    {
        $ip = self::getIp($address);
        return $ip && strpos($ip, ':') !== false;
    }
}

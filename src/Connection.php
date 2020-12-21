<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\interfaces\ConnectionInterface;
use chaser\stream\traits\Communication;
use chaser\stream\traits\Configuration;
use chaser\stream\traits\Stream;

/**
 * 连接
 *
 * @package chaser\stream
 */
abstract class Connection implements ConnectionInterface
{
    use Communication, Configuration, Stream;

    /**
     * 构造
     *
     * @param resource $stream
     * @param string $address
     */
    public function __construct($stream, string $address)
    {
        $this->stream = $stream;
        $this->remoteAddress = $address;
    }
}

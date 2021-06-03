<?php

declare(strict_types=1);

namespace chaser\stream\exception;

use Exception;

/**
 * 流服务器暂停接收客户端异常类
 *
 * @package chaser\stream\exception
 */
class ServerPauseAcceptException extends Exception implements ExceptionInterface
{
}

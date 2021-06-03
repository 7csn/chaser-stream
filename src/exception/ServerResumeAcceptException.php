<?php

declare(strict_types=1);

namespace chaser\stream\exception;

use Exception;

/**
 * 流服务器开始（或继续）接收客户端异常类
 *
 * @package chaser\stream\exception
 */
class ServerResumeAcceptException extends Exception implements ExceptionInterface
{
}

<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\reactor\Reactor;
use chaser\stream\events\Start;
use chaser\stream\exceptions\CreatedException;
use chaser\stream\interfaces\ServerInterface;
use chaser\stream\traits\{Context, Helper, Service};

/**
 * 流服务器
 *
 * @package chaser\stream
 */
abstract class Server implements ServerInterface
{
    use Context, Helper, Service;

    /**
     * 事件反应器
     *
     * @var Reactor
     */
    protected Reactor $reactor;

    /**
     * 本地地址
     *
     * @var string
     */
    protected string $localAddress;

    /**
     * 监听网络标志组合
     *
     * @var int
     */
    protected static int $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;

    /**
     * 资源流上下文配置
     *
     * @var array[]
     */
    protected array $contextOptions = [
        'socket' => [
            'backlog' => self::BACKLOG
        ]
    ];

    /**
     * 常规配置
     *
     * @var array
     */
    protected array $configurations = [];

    /**
     * 接收状态
     *
     * @var bool
     */
    protected bool $accepting = false;

    /**
     * 是否处于停止中
     *
     * @var bool
     */
    protected bool $stopping = false;

    /**
     * 关闭套接字流资源
     */
    abstract protected function close();

    /**
     * 构造函数
     *
     * @param Reactor $reactor
     * @param string $address
     */
    public function __construct(Reactor $reactor, string $address)
    {
        $this->reactor = $reactor;
        $this->localAddress = $address;

        $this->initEventDispatcher();
    }

    /**
     * @inheritDoc
     */
    public function target(): string
    {
        return $this->localAddress;
    }

    /**
     * @inheritDoc
     */
    public function start()
    {
        $this->listen();
        $this->dispatchCache(Start::class);
        $this->reactor->loop();
    }

    /**
     * @inheritDoc
     */
    public function stop()
    {
        if ($this->stopping === false) {
            $this->unListen();
            $this->stopping = true;
        }
    }

    /**
     * 创建服务器套接字流
     *
     * @throws CreatedException
     */
    protected function create()
    {
        if (!$this->stream) {

            $socketAddress = $this->socketAddress();

            $context = stream_context_create($this->contextOptions);

            $this->stream = stream_socket_server($socketAddress, $errno, $errStr, static::$flags, $context);

            if (!$this->stream) {
                throw new CreatedException("Server[$socketAddress] create failed：$errno $errStr");
            }

            stream_set_blocking($this->stream, false);
        }
    }

    /**
     * 监听网络
     *
     * @throws CreatedException
     */
    protected function listen()
    {
        $this->create();
        $this->resumeAccept();
    }

    /**
     * 移除网络监听
     */
    protected function unListen()
    {
        $this->pauseAccept();
        $this->close();
    }

    /**
     * 开始或继续接收
     */
    protected function resumeAccept()
    {
        if ($this->stream && $this->accepting === false) {
            $this->reactor->addRead($this->stream, [$this, 'accept']);
            $this->accepting = true;
        }
    }

    /**
     * 暂停接收
     */
    protected function pauseAccept()
    {
        if ($this->stream && $this->accepting === true) {
            $this->reactor->delRead($this->stream);
            $this->accepting = false;
        }
    }

    /**
     * 析构函数：移除网络监听
     */
    public function __destruct()
    {
        $this->unListen();
    }
}

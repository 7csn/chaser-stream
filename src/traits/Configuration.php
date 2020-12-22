<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 配置
 *
 * @package chaser\stream\traits
 */
trait Configuration
{
    /**
     * @inheritDoc
     */
    public function set(array $options)
    {
        foreach ($options as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function __set(string $name, $value)
    {
        if (gettype($this->{$name}) === gettype($value)) {
            $this->configurations[$name] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function __get(string $name)
    {
        return $this->configurations[$name] ?? null;
    }
}

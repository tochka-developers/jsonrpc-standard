<?php

namespace Tochka\JsonRpc\Standard\Exceptions;

/**
 * @psalm-api
 */
class MethodNotFoundException extends JsonRpcException
{
    public function __construct(?string $message = null, array|object|null $data = null, ?\Throwable $previous = null)
    {
        parent::__construct(self::CODE_METHOD_NOT_FOUND, $message, $data, $previous);
    }
}

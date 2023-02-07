<?php

namespace Tochka\JsonRpc\Standard\Exceptions;

/**
 * @psalm-api
 */
class InvalidParamsException extends JsonRpcException
{
    public function __construct(?string $message = null, array|object|null $data = null, ?\Throwable $previous = null)
    {
        parent::__construct(self::CODE_INVALID_PARAMS, $message, $data, $previous);
    }
}

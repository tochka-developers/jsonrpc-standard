<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Additional;

/**
 * @psalm-api
 */
class UnauthorizedException extends AdditionalJsonRpcException
{
    public function __construct(?string $message = null, array|object|null $data = null, ?\Throwable $previous = null)
    {
        parent::__construct(self::CODE_UNAUTHORIZED, $message, $data, $previous);
    }
}

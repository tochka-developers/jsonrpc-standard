<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Additional;

/**
 * @psalm-api
 */
class ValidationErrorException extends AdditionalJsonRpcException
{
    public function __construct(?string $message = null, array|object|null $data = null, ?\Throwable $previous = null)
    {
        parent::__construct(self::CODE_VALIDATION_ERROR, $message, $data, $previous);
    }
}

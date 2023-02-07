<?php

namespace Tochka\JsonRpc\Standard\Exceptions;

use Tochka\JsonRpc\Standard\Exceptions\Errors\InvalidDataError;

/**
 * @psalm-api
 */
class InvalidRequestException extends JsonRpcException
{
    public function __construct(
        ?string $message = null,
        ?InvalidDataError $error = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct(self::CODE_INVALID_REQUEST, $message, $error, $previous);
    }

    public static function from(string $field, string $message, ?\Throwable $previous = null): self
    {
        return new self(null, new InvalidDataError($field, $message), $previous);
    }
}

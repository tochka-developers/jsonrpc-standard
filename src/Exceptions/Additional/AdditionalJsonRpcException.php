<?php

namespace Tochka\JsonRpc\Standard\Exceptions\Additional;

use Tochka\JsonRpc\Standard\Exceptions\JsonRpcException;

/**
 * @psalm-api
 */
class AdditionalJsonRpcException extends JsonRpcException
{
    public const CODE_INVALID_PARAMETERS = 6000;
    public const CODE_VALIDATION_ERROR = 6001;
    public const CODE_UNAUTHORIZED = 7000;
    public const CODE_FORBIDDEN = 7001;
    public const CODE_EXTERNAL_INTEGRATION_ERROR = 8000;
    public const CODE_INTERNAL_INTEGRATION_ERROR = 8001;

    public const ADDITIONAL_DEFAULT_MESSAGES = [
        self::CODE_INVALID_PARAMETERS => 'Invalid parameters',
        self::CODE_VALIDATION_ERROR => 'Validation error',
        self::CODE_UNAUTHORIZED => 'Unauthorized',
        self::CODE_FORBIDDEN => 'Forbidden',
        self::CODE_EXTERNAL_INTEGRATION_ERROR => 'External integration error',
        self::CODE_INTERNAL_INTEGRATION_ERROR => 'Internal integration error',
    ];

    public static function getDefaultMessage(int $code, ?string $message = null): string
    {
        return $message ?? static::DEFAULT_MESSAGES[$code] ?? static::ADDITIONAL_DEFAULT_MESSAGES[$code] ?? 'Unexpected error';
    }
}

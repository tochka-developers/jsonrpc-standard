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

    public const MESSAGE_INVALID_PARAMETERS = 'Invalid parameters';
    public const MESSAGE_VALIDATION_ERROR = 'Validation error';
    public const MESSAGE_UNAUTHORIZED = 'Unauthorized';
    public const MESSAGE_FORBIDDEN = 'Forbidden';
    public const MESSAGE_EXTERNAL_INTEGRATION_ERROR = 'External integration error';
    public const MESSAGE_INTERNAL_INTEGRATION_ERROR = 'Internal integration error';

    public const ADDITIONAL_DEFAULT_MESSAGES = [
        self::CODE_INVALID_PARAMETERS => self::MESSAGE_INVALID_PARAMETERS,
        self::CODE_VALIDATION_ERROR => self::MESSAGE_VALIDATION_ERROR,
        self::CODE_UNAUTHORIZED => self::MESSAGE_UNAUTHORIZED,
        self::CODE_FORBIDDEN => self::MESSAGE_FORBIDDEN,
        self::CODE_EXTERNAL_INTEGRATION_ERROR => self::MESSAGE_EXTERNAL_INTEGRATION_ERROR,
        self::CODE_INTERNAL_INTEGRATION_ERROR => self::MESSAGE_INTERNAL_INTEGRATION_ERROR,
    ];

    public static function getDefaultMessage(int $code, ?string $message = null): string
    {
        return $message ?? static::DEFAULT_MESSAGES[$code] ?? static::ADDITIONAL_DEFAULT_MESSAGES[$code] ?? 'Unexpected error';
    }
}

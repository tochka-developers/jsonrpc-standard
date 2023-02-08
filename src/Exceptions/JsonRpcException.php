<?php

namespace Tochka\JsonRpc\Standard\Exceptions;

use Tochka\JsonRpc\Standard\Contracts\JsonRpcExceptionInterface;
use Tochka\JsonRpc\Standard\DTO\JsonRpcError;

/**
 * @psalm-api
 */
class JsonRpcException extends \RuntimeException implements JsonRpcExceptionInterface
{
    public const CODE_PARSE_ERROR = -32700;
    public const CODE_INVALID_REQUEST = -32600;
    public const CODE_INVALID_RESPONSE = -32610;
    public const CODE_METHOD_NOT_FOUND = -32601;
    public const CODE_INVALID_PARAMS = -32602;
    public const CODE_INTERNAL_ERROR = -32603;
    public const CODE_UNEXPECTED_CODE = -32620;

    public const DEFAULT_MESSAGES = [
        self::CODE_PARSE_ERROR => 'Parse error',
        self::CODE_INVALID_REQUEST => 'Invalid Request',
        self::CODE_INVALID_RESPONSE => 'Invalid Response',
        self::CODE_METHOD_NOT_FOUND => 'Method not found',
        self::CODE_INVALID_PARAMS => 'Invalid params',
        self::CODE_INTERNAL_ERROR => 'Internal error',
        self::CODE_UNEXPECTED_CODE => 'Unexpected code error',
    ];

    private array|object|null $data;

    public function __construct(int $code, string $message = null, array|object|null $data = null, ?\Throwable $previous = null)
    {
        $message = static::getDefaultMessage($code, $message);
        parent::__construct($message, $code, $previous);

        $this->data = $data;
    }

    public function getJsonRpcError(): JsonRpcError
    {
        return new JsonRpcError($this->getCode(), $this->getMessage(), $this->data);
    }

    public static function getDefaultMessage(int $code, ?string $message = null): string
    {
        return $message ?? static::DEFAULT_MESSAGES[$code] ?? 'Unexpected error';
    }
}

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

    public const MESSAGE_PARSE_ERROR = 'Parse error';
    public const MESSAGE_INVALID_REQUEST = 'Invalid Request';
    public const MESSAGE_INVALID_RESPONSE = 'Invalid Response';
    public const MESSAGE_METHOD_NOT_FOUND = 'Method not found';
    public const MESSAGE_INVALID_PARAMS = 'Invalid params';
    public const MESSAGE_INTERNAL_ERROR = 'Internal error';
    public const MESSAGE_UNEXPECTED_CODE = 'Unexpected code error';

    public const DEFAULT_MESSAGES = [
        self::CODE_PARSE_ERROR => self::MESSAGE_PARSE_ERROR,
        self::CODE_INVALID_REQUEST => self::MESSAGE_INVALID_REQUEST,
        self::CODE_INVALID_RESPONSE => self::MESSAGE_INVALID_RESPONSE,
        self::CODE_METHOD_NOT_FOUND => self::MESSAGE_METHOD_NOT_FOUND,
        self::CODE_INVALID_PARAMS => self::MESSAGE_INVALID_PARAMS,
        self::CODE_INTERNAL_ERROR => self::MESSAGE_INTERNAL_ERROR,
        self::CODE_UNEXPECTED_CODE => self::MESSAGE_UNEXPECTED_CODE,
    ];

    private array|object|null $data;

    public function __construct(
        int $code,
        string $message = null,
        array|object|null $data = null,
        ?\Throwable $previous = null,
    ) {
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

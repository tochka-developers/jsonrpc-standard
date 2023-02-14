<?php

namespace Tochka\JsonRpc\Standard\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Tochka\JsonRpc\Standard\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Standard\Helpers\PrepareValue;

/**
 * @psalm-api
 * @psalm-suppress MissingTemplateParam
 * @psalm-type JsonRpcErrorArray = array{
 *     code: int,
 *     message: string,
 *     data?: array|object
 * }
 */
final class JsonRpcError implements Arrayable, Jsonable, \JsonSerializable
{
    use PrepareValue;

    public int $code;
    public string $message;
    public array|object|null $data = null;

    public function __construct(int $code, string $message, array|object|null $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public static function from(object|array $value): self
    {
        if (is_array($value)) {
            $value = (object)$value;
        }

        $code = isset($value->code) && is_int($value->code)
            ? $value->code
            : JsonRpcException::CODE_UNEXPECTED_CODE;

        $message = isset($value->message) && is_string($value->message)
            ? $value->message
            : JsonRpcException::DEFAULT_MESSAGES[JsonRpcException::CODE_UNEXPECTED_CODE];

        $data = isset($value->data) && (is_object($value->data) || is_array($value->data))
            ? $value->data
            : null;

        return new self($code, $message, $data);
    }

    /**
     * @return JsonRpcErrorArray
     */
    public function toArray(): array
    {
        $result = [
            'code' => $this->code,
            'message' => $this->message
        ];

        if ($this->data !== null) {
            $result['data'] = $this->prepareValueForArrayable($this->data);
        }

        return $result;
    }

    /**
     * @return JsonRpcErrorArray
     */
    public function jsonSerialize(): array
    {
        $result = [
            'code' => $this->code,
            'message' => $this->message
        ];

        if ($this->data !== null) {
            $result['data'] = $this->prepareValueForJsonable($this->data);
        }

        return $result;
    }

    /**
     * @throws \JsonException
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), JSON_THROW_ON_ERROR | $options | JSON_UNESCAPED_UNICODE);
    }
}

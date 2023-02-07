<?php

namespace Tochka\JsonRpc\Standard\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Tochka\JsonRpc\Standard\Contracts\JsonRpcInterface;
use Tochka\JsonRpc\Standard\Exceptions\InvalidRequestException;
use Tochka\JsonRpc\Standard\Helpers\PrepareValue;

/**
 * @psalm-api
 * @psalm-suppress MissingTemplateParam
 * @psalm-type JsonRpcRequestArray = array{
 *     jsonrpc: string,
 *     id?: string|int,
 *     method: string,
 *     params?: array|object,
 * }
 */
final class JsonRpcRequest implements JsonRpcInterface, Arrayable, Jsonable, \JsonSerializable
{
    use PrepareValue;

    public string $jsonrpc = self::VERSION;
    public string $method;
    public array|object|null $params = null;
    public string|int|null $id = null;

    public function __construct(string $method, array|object|null $params = null, string|int|null $id = null)
    {
        $this->method = $method;
        $this->params = $params;
        $this->id = $id;
    }

    public static function from(object|array $value): self
    {
        if (is_array($value)) {
            $value = (object)$value;
        }

        if (empty($value->jsonrpc) || $value->jsonrpc !== self::VERSION) {
            throw InvalidRequestException::from('jsonrpc', 'Field must be [2.0]');
        }

        if (empty($value->method)) {
            throw InvalidRequestException::from('method', 'Field must be present');
        }

        if (!is_string($value->method)) {
            throw InvalidRequestException::from('method', 'Field must be of type [string]');
        }

        if (isset($value->params) && !is_array($value->params) && !is_object($value->params)) {
            throw InvalidRequestException::from('params', 'Field must be of type [array|object]');
        }

        if (isset($value->id) && !is_string($value->id) && !is_int($value->id)) {
            throw InvalidRequestException::from('params', 'Field must be of type [array|object]');
        }

        return new self(
            $value->method,
            $value->params ?? null,
            $value->id ?? null
        );
    }

    /**
     * @return JsonRpcRequestArray
     */
    public function toArray(): array
    {
        $result = [
            'jsonrpc' => $this->jsonrpc,
            'method' => $this->method
        ];

        if ($this->params !== null) {
            $result['params'] = $this->prepareValueForArrayable($this->params);
        }

        if ($this->id !== null) {
            $result['id'] = $this->id;
        }

        return $result;
    }

    /**
     * @return JsonRpcRequestArray
     */
    public function jsonSerialize(): array
    {
        $result = [
            'jsonrpc' => $this->jsonrpc,
            'method' => $this->method
        ];

        if ($this->params !== null) {
            $result['params'] = $this->prepareValueForJsonable($this->params);
        }

        if ($this->id !== null) {
            $result['id'] = $this->id;
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

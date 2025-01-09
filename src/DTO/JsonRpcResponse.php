<?php

namespace Tochka\JsonRpc\Standard\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Tochka\JsonRpc\Standard\Contracts\JsonRpcInterface;
use Tochka\JsonRpc\Standard\Exceptions\InvalidResponseException;
use Tochka\JsonRpc\Standard\Helpers\PrepareValue;

/**
 * @psalm-api
 * @psalm-suppress MissingTemplateParam
 * @psalm-type JsonRpcResponseArray = array{
 *     jsonrpc: string,
 *     id: string|int,
 *     result?: mixed,
 *     error?: array|object,
 * }
 */
final class JsonRpcResponse implements JsonRpcInterface, Arrayable, Jsonable, \JsonSerializable
{
    use PrepareValue;

    public const ID_EMPTY = 'empty';

    public string $jsonrpc = self::VERSION;
    public string|int $id;
    public mixed $result;
    public ?JsonRpcError $error;

    public function __construct(string|int|null $id = null, mixed $result = null, JsonRpcError $error = null)
    {
        $this->id = $id ?? self::ID_EMPTY;
        $this->result = $result;
        $this->error = $error;
    }

    public static function from(object|array $value): self
    {
        if (is_array($value)) {
            $value = (object) $value;
        }

        if (empty($value->jsonrpc) || $value->jsonrpc !== self::VERSION) {
            throw InvalidResponseException::from('jsonrpc', 'Field must be [2.0]');
        }

        if (empty($value->id)) {
            throw InvalidResponseException::from('id', 'Field must be present');
        }

        if (!is_string($value->id) && !is_int($value->id)) {
            throw InvalidResponseException::from('id', 'Field must be of type [string|int]');
        }

        if (isset($value->error)) {
            if (!is_array($value->error) && !is_object($value->error)) {
                throw InvalidResponseException::from('error', 'Field must be of type [array|object]');
            }

            $error = JsonRpcError::from($value->error);
        } else {
            $error = null;
        }

        return new self(
            $value->id,
            $value->result ?? null,
            $error,
        );
    }

    /**
     * @return JsonRpcResponseArray
     */
    public function toArray(): array
    {
        $result = [
            'jsonrpc' => $this->jsonrpc,
            'id' => $this->id,
        ];

        if ($this->result !== null) {
            /** @psalm-suppress MixedAssignment */
            $result['result'] = $this->prepareValueForArrayable($this->result);
        }

        if ($this->error !== null) {
            $result['error'] = $this->error->toArray();
        }

        return $result;
    }

    /**
     * @return JsonRpcResponseArray
     */
    public function jsonSerialize(): array
    {
        $result = [
            'jsonrpc' => $this->jsonrpc,
            'id' => $this->id,
        ];

        if ($this->result !== null) {
            /** @psalm-suppress MixedAssignment */
            $result['result'] = $this->prepareValueForJsonable($this->result);
        }

        if ($this->error !== null) {
            $result['error'] = $this->error->jsonSerialize();
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

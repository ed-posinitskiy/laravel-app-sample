<?php

namespace App\Http\Response\Ajax;

use ArrayObject;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use JsonSerializable;

/**
 * Class UpdateResponseModel
 *
 * @package App\Http\Response\Ajax
 */
class UpdateResponseModel extends MessageResponseModel
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * ReloadResponseModel constructor.
     *
     * @param mixed  $data
     * @param string $message
     */
    public function __construct($data, $message)
    {
        $this->guardForData($data);

        parent::__construct($message);

        $this->data = $data;
        $this->type = static::TYPE_UPDATE;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'message' => $this->message,
            'values'  => $this->data,
        ];
    }

    /**
     * @param $data
     */
    protected function guardForData($data)
    {
        if (is_array($data)
            || $data instanceof JsonSerializable
            || $data instanceof Arrayable
            || $data instanceof Jsonable
            || $data instanceof ArrayObject
        ) {
            return;
        }
        throw new InvalidArgumentException('Data has invalid type and cannot be converted to json response');
    }
}

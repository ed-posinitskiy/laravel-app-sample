<?php

namespace App\Http\Response\Ajax;

use JsonSerializable;

/**
 * Class AbstractResponseModel
 *
 * @package App\Http\Response\Ajax
 */
abstract class AbstractResponseModel implements ResponseModel, JsonSerializable
{
    /**
     * @var string
     */
    protected $type;

    /**
     * AbstractResponseModel constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->getData(),
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}

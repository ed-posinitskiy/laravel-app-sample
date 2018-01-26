<?php

namespace App\Http\Response\Ajax;

/**
 * Class MessageResponseModel
 *
 * @package App\Http\Response\Ajax
 */
class MessageResponseModel extends AbstractResponseModel
{

    /**
     * @var string
     */
    protected $message;

    /**
     * MessageResponseModel constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;

        parent::__construct(static::TYPE_MESSAGE);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return ['message' => $this->message];
    }
}

<?php

namespace App\Http\Response\Ajax;

/**
 * Class RedirectResponseModel
 *
 * @package App\Http\Response\Ajax
 */
class RedirectResponseModel extends MessageResponseModel
{

    /**
     * @var string
     */
    protected $redirect;

    /**
     * RedirectResponseModel constructor.
     *
     * @param string $redirect
     * @param string $message
     */
    public function __construct($redirect, $message)
    {
        parent::__construct($message);

        $this->redirect = $redirect;
        $this->type     = static::TYPE_REDIRECT;
    }


    /**
     * @return array
     */
    public function getData(): array
    {
        return array_merge(parent::getData(), ['redirect' => $this->redirect]);
    }

    /**
     * @param string $message
     * @param string $uri
     *
     * @return static
     */
    public static function withMessageAndUri(string $message, string $uri)
    {
        return new static($uri, $message);
    }
}

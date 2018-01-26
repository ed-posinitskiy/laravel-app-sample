<?php

namespace App\Http\Response\Ajax;

/**
 * Interface ResponseModel
 *
 * @package App\Http\Response\Ajax
 */
interface ResponseModel
{
    const TYPE_MESSAGE  = 'message';
    const TYPE_REDIRECT = 'redirect';
    const TYPE_UPDATE   = 'update';
    const TYPE_CRUD     = 'crud';

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return array
     */
    public function toArray(): array;
}

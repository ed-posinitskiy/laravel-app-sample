<?php

namespace App\Http\Resource\Helper;

/**
 * Trait MessageResourceTrait
 *
 * @package App\Http\Resource\Helper
 */
trait MessageResourceTrait
{
    public function withMessage($message)
    {
        $this->withMeta('message', $message);
    }
}

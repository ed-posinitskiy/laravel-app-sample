<?php

namespace App\Http\Resource\Helper;

/**
 * Trait RedirectResourceTrait
 *
 * @package App\Http\Resource\Helper
 */
trait RedirectResourceTrait
{
    public function withRedirect($redirect)
    {
        $this->withMeta('redirect', $redirect);
    }
}

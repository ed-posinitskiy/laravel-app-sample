<?php

namespace App\Http\Resource;

use App\Http\Resource\Helper\MessageResourceTrait;
use App\Http\Resource\Helper\MetaProviderTrait;
use App\Http\Resource\Helper\RedirectResourceTrait;
use Illuminate\Http\Resources\Json\Resource;

/**
 * Class EmptyResource
 *
 * @package App\Http\Resource
 */
class EmptyResource extends Resource
{
    use MetaProviderTrait,
        MessageResourceTrait,
        RedirectResourceTrait;

    public function __construct()
    {
        parent::__construct(null);
    }

    public function toArray($request)
    {
        return [];
    }
}

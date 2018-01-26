<?php

namespace App\Http\Resource\Helper;

/**
 * Class ResourceBehavioursTrait
 *
 * @package App\Http\Resource\Helper
 */
trait ResourceBehavioursTrait
{
    use MetaProviderTrait,
        MessageResourceTrait,
        RedirectResourceTrait,
        CrudResourceTrait,
        ResourceWrapperTrait;
}

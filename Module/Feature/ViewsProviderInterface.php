<?php

namespace App\Module\Feature;

/**
 * Interface ViewsProviderInterface
 *
 * @package App\Module\Feature
 */
interface ViewsProviderInterface
{
    /**
     * @return string
     */
    public function getViewsPath();
}

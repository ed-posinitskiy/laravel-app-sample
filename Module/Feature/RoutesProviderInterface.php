<?php

namespace App\Module\Feature;

/**
 * Interface RoutesProviderInterface
 *
 * @package App\Module\Feature
 */
interface RoutesProviderInterface
{
    /**
     * @return string
     */
    public function getRoutesPath();
}

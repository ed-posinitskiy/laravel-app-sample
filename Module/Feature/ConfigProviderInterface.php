<?php

namespace App\Module\Feature;

/**
 * Interface ConfigProviderInterface
 *
 * @package App\Module\Feature
 */
interface ConfigProviderInterface
{
    /**
     * @return string
     */
    public function getConfigPath();
}

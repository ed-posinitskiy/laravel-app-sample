<?php

namespace App\Module\Feature;

/**
 * Trait ProvidesNamespacedPath
 *
 * @package App\Module\Feature
 */
trait ProvidesNamespacedPath
{
    /**
     * @param string $path
     * @param string $delimiter
     *
     * @return string
     */
    public static function ns($path, $delimiter = '::')
    {
        if (!defined('static::ALIAS')) {
            throw new \RuntimeException('Constant ALIAS is not defined');
        }

        return sprintf('%s%s%s', static::ALIAS, $delimiter, $path);
    }
}

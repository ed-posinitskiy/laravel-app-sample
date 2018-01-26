<?php

namespace App\Http\Resource\Helper;

/**
 * Trait MetaProviderTrait
 *
 * @package App\Http\Resource\Helper
 */
trait MetaProviderTrait
{
    /**
     * @param string $key
     * @param mixed  $value
     */
    public function withMeta(string $key, $value): void
    {
        $this->with['meta'][$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasMeta(string $key): bool
    {
        return isset($this->with['meta'][$key]);
    }
}

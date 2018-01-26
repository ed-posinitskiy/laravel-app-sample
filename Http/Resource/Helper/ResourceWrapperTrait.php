<?php

namespace App\Http\Resource\Helper;

use Illuminate\Support\Collection;

/**
 * Class ResourceWrapperTrait
 *
 * @package App\Http\Resource\Helper
 */
trait ResourceWrapperTrait
{
    /**
     * Wrap the given data if necessary.
     *
     * @param  array $data
     * @param  array $with
     * @param  array $additional
     *
     * @return array
     */
    protected function doWrap($data, $with = [], $additional = [])
    {
        if ($data instanceof Collection) {
            $data = $data->all();
        }

        $data = [(static::$wrap ?? 'data') => $data];

        return array_merge_recursive($data, $with, $additional);
    }
}

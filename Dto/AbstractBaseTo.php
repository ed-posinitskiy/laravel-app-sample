<?php

namespace App\Dto;

/**
 * Class AbstractBaseTo
 *
 * @package App\Dto
 */
abstract class AbstractBaseTo
{

    use StoresOriginalModel;

    /**
     * @return array
     */
    protected function getFillableProperties(): array
    {
        return $this->getPublicProperties();
    }

    /**
     * @return array
     */
    protected function getPublicProperties(): array
    {
        $properties = array_keys(get_object_vars($this));

        return array_filter(
            $properties,
            function ($value) {
                return $value !== 'originalModel';
            });
    }
}

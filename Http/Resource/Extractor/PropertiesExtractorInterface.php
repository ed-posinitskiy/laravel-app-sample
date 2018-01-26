<?php

namespace App\Http\Resource\Extractor;

/**
 * Class PropertiesExctractorInterface
 *
 * @package App\Http\Resource
 */
interface PropertiesExtractorInterface extends ExtractorInterface
{
    /**
     * Defines properties to extract from object
     *
     * @param array $properties
     */
    public function properties(array $properties): void;
}

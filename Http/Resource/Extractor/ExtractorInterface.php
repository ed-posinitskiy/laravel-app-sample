<?php

namespace App\Http\Resource\Extractor;

/**
 * Interface ExtractorInterface
 *
 * @package App\Http\Resource\Extractor
 */
interface ExtractorInterface
{
    /**
     * @param object $object
     */
    public function extract($object): void;

    /**
     * Extracts given (via extract() method) object to array
     *
     * @return array
     */
    public function toArray(): array;
}

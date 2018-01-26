<?php

namespace App\Http\Resource\Extractor;

/**
 * Interface ExtractorAwareResource
 *
 * @package App\Http\Resource
 */
interface ExtractorAwareResource
{
    /**
     * @param ExtractorInterface $extractor
     *
     * @return void
     */
    public function setExtractor(ExtractorInterface $extractor);
}

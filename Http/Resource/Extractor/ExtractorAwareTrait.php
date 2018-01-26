<?php

namespace App\Http\Resource\Extractor;

/**
 * Trait ExtractorAwareTrait
 *
 * @package App\Http\Resource\Extractor
 */
trait ExtractorAwareTrait
{
    /**
     * @var ExtractorInterface
     */
    protected $extractor;

    /**
     * @param ExtractorInterface $extractor
     *
     * @return void
     */
    public function setExtractor(ExtractorInterface $extractor): void
    {
        $this->extractor = $extractor;
    }
}

<?php

namespace App\Http\Resource;

use App\Http\Resource\Extractor\ExtractorAwareResource;
use App\Http\Resource\Extractor\ExtractorAwareTrait;
use App\Http\Resource\Extractor\ExtractorInterface;
use App\Http\Resource\Helper\ResourceBehavioursTrait;
use Illuminate\Http\Resources\Json\Resource;

/**
 * Class AbstractExtractableResource
 *
 * @package App\Http\Resource
 */
abstract class AbstractExtractableResource extends Resource implements ExtractorAwareResource
{
    use ExtractorAwareTrait,
        ResourceBehavioursTrait;

    public function toArray($request)
    {
        $data = $this->extractor ? $this->extract($this->extractor, $this->resource) : parent::toArray($request);

        return $this->doWrap(
            $data,
            $this->with($request),
            $this->additional
        );
    }

    /**
     * @param ExtractorInterface $extractor
     * @param object             $resource
     *
     * @return array
     */
    abstract protected function extract(ExtractorInterface $extractor, $resource): array;
}

<?php

namespace App\Http\Resource;

use App\Http\Resource\Helper\ResourceBehavioursTrait;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

/**
 * Class ResourceCollection
 *
 * @package App\Http\Resource
 */
class ResourceCollection extends BaseResourceCollection
{
    use ResourceBehavioursTrait;

    /**
     * @var ResourcesMap
     */
    protected $resourcesMap;

    /**
     * ResourceCollection constructor.
     *
     * @param ResourcesMap $resourcesMap
     * @param Collection   $resource
     */
    public function __construct(ResourcesMap $resourcesMap, $resource)
    {
        $this->resourcesMap = $resourcesMap;
        $this->resource     = $this->collectResource($resource);
    }

    /**
     * @param Collection $resource
     *
     * @return Collection
     */
    protected function collectResource($resource)
    {
        $resource = $this->normalizeResource($resource);

        $resource->transform(
            function ($model) {
                if ($model instanceof Resource) {
                    return $model;
                }

                return $this->resourcesMap->has($model) ? $this->resourcesMap->resource($model) : $model;
            }
        );

        return parent::collectResource($resource);
    }

    public function resolve($request = null)
    {
        if (!$this->resource instanceof AbstractPaginator) {
            $this->withMeta('total', $this->collection->count());
        }

        return parent::resolve($request);
    }

    /**
     * @param mixed $resource
     *
     * @return Collection | AbstractPaginator
     */
    protected function normalizeResource($resource)
    {
        if (!is_callable([$resource, 'transform'])) {
            return Collection::wrap($resource);
        }

        return $resource;
    }
}

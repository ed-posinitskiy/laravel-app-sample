<?php

namespace App\Http\Resource;

use App\Http\Resource\Extractor\DefaultResourceExtractor;
use App\Http\Resource\Extractor\ExtractorAwareResource;
use App\Http\Resource\Extractor\ExtractorInterface;
use Illuminate\Http\Resources\Json\Resource;
use OutOfBoundsException;
use RuntimeException;

/**
 * Class ResourcesMap
 *
 * @package App\Http\Resource
 */
class ResourcesMap
{
    /**
     * @var array
     */
    protected $map = [];

    /**
     * @var array
     */
    protected $extractor = [];

    /**
     * @var string
     */
    protected $defaultExtractorClass = DefaultResourceExtractor::class;

    /**
     * ResourcesMap constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->load($config);
    }

    /**
     * @param object $model
     *
     * @return bool
     */
    public function has($model): bool
    {
        $modelClass = $this->getModelClass($model);

        return isset($this->map[$modelClass]);
    }

    /**
     * @param object $model
     *
     * @return Resource
     */
    public function resource($model): Resource
    {
        $modelClass = $this->getModelClass($model);

        if (!$this->has($model)) {
            throw new OutOfBoundsException(
                sprintf('Resource is not defined for model [%s]', $modelClass)
            );
        }

        $resourceClass = $this->map[$modelClass];
        $resource      = new $resourceClass($model);

        if (!$resource instanceof Resource) {
            throw new RuntimeException(
                sprintf(
                    'Resource instance expected to be an instance of [%s], got [%s} for model [%s]',
                    Resource::class, $resourceClass, $modelClass
                )
            );
        }

        $this->injectExtractor($resource, $model);

        return $resource;
    }

    /**
     * @param mixed $collection
     *
     * @return ResourceCollection
     */
    public function collection($collection): ResourceCollection
    {
        return new ResourceCollection($this, $collection);
    }

    /**
     * @param array $config
     */
    protected function load(array $config)
    {
        foreach ($config as $model => $options) {
            if (is_string($options)) {
                $this->map[$model] = $options;
                continue;
            }

            if (empty($options['resource'])) {
                throw new \InvalidArgumentException(
                    sprintf('[resource] option is not defined for model [%s]', $model)
                );
            }

            $this->map[$model] = $options['resource'];

            if (!empty($options['extractor'])) {
                $this->extractor[$model] = $options['extractor'];
            }
        }
    }

    /**
     * @param Resource $resource
     * @param object   $model
     */
    protected function injectExtractor(Resource $resource, $model): void
    {
        if (!$resource instanceof ExtractorAwareResource) {
            return;
        }

        $modelClass     = $this->getModelClass($model);
        $extractorClass = isset($this->extractor[$modelClass])
            ? $this->extractor[$modelClass]
            : $this->defaultExtractorClass;

        $extractor = \App::make($extractorClass);

        if (!$extractor instanceof ExtractorInterface) {
            throw new RuntimeException(
                sprintf(
                    'Extractor expected to be an instance of [%s], got [%s] for model [%s]',
                    ExtractorInterface::class,
                    $extractorClass,
                    $modelClass
                )
            );
        }

        $extractor->extract($model);
        $resource->setExtractor($extractor);
    }

    /**
     * @param object|string $model
     *
     * @return string
     */
    protected function getModelClass($model): string
    {
        return is_object($model) ? get_class($model) : (string)$model;
    }

}

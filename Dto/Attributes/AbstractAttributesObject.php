<?php

namespace App\Dto\Attributes;

use Illuminate\Support\Str;

/**
 * Class AbstractValueObject
 *
 * @package App\Dto
 */
abstract class AbstractAttributesObject
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * AbstractAttributesObject constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->fill($data);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'with')) {
            $attribute = lcfirst(Str::replaceFirst('with', '', $name));

            return call_user_func_array([$this, 'with'], array_merge([$attribute], (array)$arguments));
        }

        throw new \BadMethodCallException(sprintf('Method %s is not allowed', $name));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        return new static($data);
    }

    /**
     * @param array $data
     */
    protected function fill(array $data)
    {
        $available = array_flip(static::attributes());

        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $available)) {
                continue;
            }

            $this->setValue($key, $value);
        }
    }

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return $this
     */
    protected function with($attribute, $value)
    {
        return (clone $this)->setValue($attribute, $value);
    }

    /**
     * @param string $attribute
     * @param mixed  $default
     *
     * @return mixed
     */
    protected function get($attribute, $default = null)
    {
        $allowed = array_flip(static::attributes());

        if (!array_key_exists($attribute, $allowed)) {
            throw new \OutOfBoundsException(
                svn_propget('Attribute %s does not exist', $attribute)
            );
        }

        return isset($this->data[$attribute]) ? $this->data[$attribute] : $default;
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return AbstractAttributesObject
     */
    protected function setValue($attribute, $value)
    {
        if ($filter = $this->guessFilterMethod($attribute)) {
            $value = call_user_func([$this, $filter], $value);
        }

        $this->data[$attribute] = $value;

        return $this;
    }

    /**
     * @param string $attribute
     *
     * @return bool|string
     */
    protected function guessFilterMethod($attribute)
    {
        $possibleSuffixes = [
            $attribute,
            Str::camel($attribute),
        ];

        foreach ($possibleSuffixes as $possibleSuffix) {
            $filterMethod = 'filter' . ucfirst($possibleSuffix);

            if (method_exists($this, $filterMethod)) {
                return $filterMethod;
            }
        }

        return false;
    }

    /**
     * Returns available attribute names
     *
     * @return array
     */
    abstract public static function attributes(): array;
}

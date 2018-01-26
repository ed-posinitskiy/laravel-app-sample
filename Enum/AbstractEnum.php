<?php

namespace App\Enum;

/**
 * Class AbstractEnum
 *
 * @package App\Enum
 */
abstract class AbstractEnum
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $labels = [];

    /**
     * @var array
     */
    protected $ordered = [];

    /**
     * ContactType constructor.
     *
     * @param array $enum
     */
    public function __construct(array $enum)
    {
        $this->initialize($enum);
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function value($name)
    {
        if (!$this->has($name)) {
            throw new \OutOfBoundsException(
                sprintf('ENUM %s does not exist', $name)
            );
        }

        return $name;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function label($name)
    {
        $value = $this->value($name);

        return $this->labels[$value];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->values[$name]);
    }

    /**
     * @return array
     */
    public function values()
    {
        return array_keys($this->values);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function __get($name)
    {
        return $this->value($name);
    }

    /**
     * @return array
     */
    public function getOrdered()
    {
        return $this->ordered;
    }

    /**
     * @param array $enum
     */
    protected function initialize(array $enum)
    {
        $this->values = [];
        $this->labels = [];

        foreach ($enum as $value => $label) {
            $this->values[$value] = true;
            $this->labels[$value] = $label;
            $this->ordered[]      = $value;
        }
    }
}

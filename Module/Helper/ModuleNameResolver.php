<?php

namespace App\Module\Helper;

/**
 * Class ModuleNameResolver
 *
 * @package App\Module\Helper
 */
class ModuleNameResolver
{
    /**
     * @var array
     */
    protected $modules = [];

    /**
     * @var array
     */
    protected $resolved = [];

    /**
     * ModuleNameResolver constructor.
     *
     * @param array $modules
     */
    public function __construct(array $modules)
    {
        $this->modules = $modules;
    }

    /**
     * @param string $fqcn
     *
     * @return string|false
     */
    public function resolve($fqcn)
    {
        if (isset($this->resolved[$fqcn])) {
            return $this->resolved[$fqcn];
        }


        $classParts = explode('\\', $fqcn);

        foreach ($this->modules as $module) {
            $moduleParts = explode('\\', $module);

            if (count($moduleParts) > count($classParts)) {
                continue;
            }

            $classPrefix = array_slice($classParts, 0, count($moduleParts));

            if ($classPrefix === $moduleParts) {
                $this->resolved[$fqcn] = $module;
                break;
            }
        }

        return isset($this->resolved[$fqcn]) ? $this->resolved[$fqcn] : false;
    }
}

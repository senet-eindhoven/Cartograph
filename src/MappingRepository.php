<?php

namespace Senet\Cartograph;

/**
 * Class MappingRepository
 * @package Senet\Cartograph
 */
class MappingRepository implements MappingRepositoryInterface
{
    /** @var array */
    private $mappingCollection = [];

    /**
     * @param string $fromClass
     * @param string $toClass
     * @param string $mappingClass
     */
    public function addMapping(string $fromClass, string $toClass, string $mappingClass): void
    {
        foreach([$fromClass, $toClass, $mappingClass] as $class)
        {
            if(!class_exists($class))
            {
                throw new \InvalidArgumentException("Given classname {$class} is not a valid class, "
                    . ' or could not be loaded. Include the file, or configure the autoloader.');
            }
        }

        // Initiate empty array when necessary.
        if(!isset($this->mappingCollection[$fromClass]))
        {
            $this->mappingCollection[$fromClass] = [];
        }

        $this->mappingCollection[$fromClass][$toClass] = $mappingClass;
    }

    /**
     * @param string $fromClass
     * @param string $toClass
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getMapping(string $fromClass, string $toClass): string
    {
        if(isset($this->mappingCollection[$fromClass][$toClass]))
        {
            return $this->mappingCollection[$fromClass][$toClass];
        }

        if(isset($this->mappingCollection[$fromClass]))
        {
            throw new \InvalidArgumentException("No mapping is set for target class `{$toClass}` and source class `{$fromClass}`."
                . 'The following target classes are available for the source:' . implode(', ', $this->mappingCollection[$fromClass]));
        }
        throw new \InvalidArgumentException("No mappings are defined for source class `{$fromClass}`.");
    }
}
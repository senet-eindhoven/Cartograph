<?php

namespace Senet\Cartograph;

use Senet\Cartograph\Mapping\MappingInterface;
use Psr\Container\ContainerInterface;

/**
 * Class MapperService
 * @package Senet\Cartograph
 */
class MapperService
{
    /**
     * @var MappingRepositoryInterface
     */
    private $mappingRepository;

    /**
     * @var null|ContainerInterface
     */
    private $container;

    /**
     * MapperService constructor.
     * @param MappingRepositoryInterface $mappingRepository
     * @param null|ContainerInterface $container
     */
    public function __construct(
        MappingRepositoryInterface $mappingRepository,
        ?ContainerInterface $container = null
    )
    {
        $this->mappingRepository = $mappingRepository;
        $this->container = $container;
    }

    /**
     * Retrieves the mapping set for a transformation of $from to $to. And uses it to map the $to object.
     *
     * @param object $from
     * @param object|string $to
     * @return object
     * @throws \InvalidArgumentException if no valid MappingObject is found.
     */
    public function map(object $from, $to): object
    {
        if (is_string($to)) {
            $to = $this->getObject($to);
        }
        $mappingClass = $this->mappingRepository->getMapping(get_class($from), get_class($to));
        $mappingObject = $this->getMapping($mappingClass);
        return $mappingObject->map($from, $to, $this);
    }

    /**
     * @param string $mappingClass
     * @return MappingInterface
     */
    private function getMapping(string $mappingClass): MappingInterface
    {
        if ($this->container !== null && $this->container->has($mappingClass)) {
            return $this->container->get($mappingClass);
        }

        if (is_subclass_of($mappingClass, MappingInterface::class) === true) {
            return (new $mappingClass());
        }

        throw new \LogicException(
            sprintf(
                'Mapping class %s does not implement MappingInterface',
                $mappingClass
            )
        );
    }

    /**
     * @param string $className
     * @return object
     * @throws \InvalidArgumentException
     */
    private function getObject(string $className): object
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Invalid class `{$className}`. Check that the classname is spelled " .
                ' correctly, and the class is included or the autoloader is configured correctly.');
        }
        return new $className();
    }
}

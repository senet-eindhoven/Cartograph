<?php

namespace SenetEindhoven\Cartograph;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;

/**
 * Class EntityMappingRepository
 * @package SenetEindhoven\Cartograph
 */
final class EntityMappingRepository extends MappingRepository
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * EntityMappingRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $fromClass
     * @param string $toClass
     * @param string $mappingClass
     */
    public function addMapping(string $fromClass, string $toClass, string $mappingClass): void
    {
        parent::addMapping(
            $this->getRealClass($fromClass),
            $this->getRealClass($toClass),
            $this->getRealClass($mappingClass)
        );
    }

    /**
     * @param string $fromClass
     * @param string $toClass
     * @return string
     */
    public function getMapping(string $fromClass, string $toClass): string
    {
        $from = $this->getRealClass($fromClass);
        $to = $this->getRealClass($toClass);

        return parent::getMapping(
            $from,
            $to
        );
    }

    /**
     * @param string $className
     * @return string
     */
    private function getRealClass(string $className): string
    {
        if (in_array(\Doctrine\ORM\Proxy\Proxy::class, class_implements($className)) === false)
        {
            return $className;
        }
        return ClassUtils::getRealClass($className);
    }
}
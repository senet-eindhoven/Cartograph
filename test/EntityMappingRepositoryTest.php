<?php

namespace SenetEindhoven\Cartograph\test;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use SenetEindhoven\Cartograph\EntityMappingRepository;
use SenetEindhoven\Cartograph\Mapping\MappingInterface;
use SenetEindhoven\Cartograph\TestClasses\Bar;
use SenetEindhoven\Cartograph\TestClasses\Foo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class EntityMappingRepositoryTest extends TestCase
{
    /** @var EntityManagerInterface|MockObject */
    private $entityManager;

    /** @var EntityMappingRepository */
    private $entityMappingRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->entityMappingRepository = new EntityMappingRepository($this->entityManager);
    }

    /**
     * Tests adding and retrieving the mapping with real classes.
     */
    public function testAddMapping(): void
    {
        $mappingClass = $this->createMock(MappingInterface::class);

        $this->entityMappingRepository->addMapping(
            Foo::class,
            Bar::class,
            get_class($mappingClass)
        );

        $returnedMappingClass = $this->entityMappingRepository->getMapping(Foo::class, Bar::class);
        $this->assertEquals(get_class($mappingClass), $returnedMappingClass);
    }
}
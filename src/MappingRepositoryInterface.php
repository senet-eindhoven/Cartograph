<?php

namespace SenetEindhoven\Cartograph;

/**
 * Interface MappingRepositoryInterface
 * @package cartograph\src
 */
interface MappingRepositoryInterface
{
    /**
     * Register a new mapping between two classes.
     * @param string $fromClass
     * @param string $toClass
     * @param string $mappingClass
     * @return void
     */
    public function addMapping(string $fromClass, string $toClass, string $mappingClass): void;

    /**
     * Retrieve the registered mapping for two given classes.
     * @param $fromClass
     * @param $toClass
     * @return string
     */
    public function getMapping(string $fromClass, string $toClass): string;
}
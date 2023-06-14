<?php

namespace SenetEindhoven\Cartograph\Mapping;
use SenetEindhoven\Cartograph\MapperService;

/**
 * Interface MappingInterface
 * @package SenetEindhoven\Cartograph\Mapping
 */
interface MappingInterface
{
    /**
     * @param object $from
     * @param object $to
     * @param MapperService $mapperService
     * @return object
     */
    public function map(object $from, object $to, MapperService $mapperService): object;
}
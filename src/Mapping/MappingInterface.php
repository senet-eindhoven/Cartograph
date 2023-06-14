<?php

namespace Senet\Cartograph\Mapping;

use Senet\Cartograph\MapperService;

/**
 * Interface MappingInterface
 * @package Senet\Cartograph\Mapping
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
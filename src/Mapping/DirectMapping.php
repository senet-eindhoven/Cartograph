<?php

namespace Senet\Cartograph\Mapping;

use Senet\Cartograph\MapperService;

/**
 * Class DirectMapping
 * @package Senet\Cartograph\Mapping
 */
class DirectMapping implements MappingInterface
{
    /**
     * @param object $from
     * @param object $to
     * @param MapperService $mapperService
     * @return object
     * @throws \ReflectionException
     */
    public function map(object $from, object $to, MapperService $mapperService): object
    {
        $this->mapAttributeValues($this->getAttributeValues($from), $to);
        return $to;
    }

    /**
     * Maps the properties of the $from Object to an associative array.
     *
     * @param object $from
     * @return array
     * @throws \ReflectionException
     */
    private function getAttributeValues(object $from): array
    {
        $reflect = new \ReflectionClass($from);
        $attributes = $reflect->getProperties();

        $attributeValues = [];
        foreach($attributes as $attribute)
        {
            if($attribute->isStatic())
            {
                continue;
            }

            $attributeValues[$attribute->getName()] = $attribute->getValue();
        }

        return $attributeValues;
    }

    /**
     * @param array $attributeValues
     * @param object $to
     * @throws \ReflectionException
     */
    private function mapAttributeValues(array $attributeValues, object $to): void
    {
        $reflect = new \ReflectionClass($to);
        foreach($attributeValues as $name => $value)
        {
            try{
                $property = $reflect->getProperty($name);
                if($property->isPublic())
                {
                    $to->$name = $value;
                }
                $setterMethod = 'set' . ucfirst($name);
                if($reflect->getMethod($setterMethod))
                {
                    $to->$setterMethod($value);
                }
            }
            catch(\ReflectionException $e)
            {
                continue;
            }
        }
    }
}

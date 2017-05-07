<?php

namespace Ibrows\ImportBundle\Converter;

use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;

class SimpleArrayConverter extends AbstractConverter
{
    public function transformToPHP($value, MappingInterface $mappingInformation)
    {
        return $value;
    }
}

<?php

namespace Ibrows\ImportBundle\Converter;

use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;

class IntegerConverter extends AbstractConverter
{
    public function transformToPHP($value, MappingInterface $mappingInformation)
    {
        return (int)$value;
    }
}

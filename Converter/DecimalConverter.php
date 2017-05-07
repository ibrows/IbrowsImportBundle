<?php

namespace Ibrows\ImportBundle\Converter;

use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;

class DecimalConverter extends AbstractConverter
{
    public function transformToPHP($value, MappingInterface $mappingInformation)
    {
        return (double)$value;
    }
}

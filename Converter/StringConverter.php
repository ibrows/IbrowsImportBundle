<?php

namespace Ibrows\ImportBundle\Converter;

use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;

class StringConverter extends AbstractConverter
{
    public function transformToPHP($value, MappingInterface $mappingInformation)
    {
        return (string)$value;
    }
}

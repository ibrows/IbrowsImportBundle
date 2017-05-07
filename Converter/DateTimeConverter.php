<?php

namespace Ibrows\ImportBundle\Converter;

use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;

class DateTimeConverter extends AbstractConverter
{
    public function transformToPHP($value, MappingInterface $mappingInformation)
    {
        return new \DateTime($value);
    }
}

<?php

namespace Ibrows\ImportBundle\Converter;

use Ibrows\ImportBundle\Annotation\ResolveByImporterInterface;

abstract class AbstractConverter implements ConverterInterface
{
    public function transformToCompare($value, ResolveByImporterInterface $mappingInformation)
    {
        return $value;
    }
}

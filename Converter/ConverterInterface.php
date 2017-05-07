<?php

namespace Ibrows\ImportBundle\Converter;

use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;
use Ibrows\ImportBundle\Annotation\ResolveByImporterInterface;

interface ConverterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function transformToPHP($value, MappingInterface $mappingInformation);

    /**
     * @param mixed $value
     * @param ResolveByImporterInterface $mappingInformation
     * @return mixed
     */
    public function transformToCompare($value, ResolveByImporterInterface $mappingInformation);
}

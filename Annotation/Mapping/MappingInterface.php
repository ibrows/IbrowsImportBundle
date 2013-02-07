<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

use Ibrows\ImportBundle\Annotation\ResolveByImporterInterface;

interface MappingInterface extends ResolveByImporterInterface
{
    /**
     * @return string
     */
    public function getFieldName();

    /**
     * @return string
     */
    public function getSetterName();

    /**
     * @return string
     */
    public function getGetterName();

    /**
     * @param mixed $value
     * @return mixed
     */
    public function transformToPHP($value);

    /**
     * @param mixed $value
     * @return mixed
     */
    public function transformToCompare($value);

    /**
     * @return bool
     */
    public function ignoreBlank();
}
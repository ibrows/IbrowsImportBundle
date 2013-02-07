<?php

namespace Ibrows\ImportBundle\Annotation\Compare;
use Ibrows\ImportBundle\Annotation\ResolveByImporterInterface;

interface CompareInterface extends ResolveByImporterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function transformToCompare($value);

    /**
     * @return string
     */
    public function getGetterName();

}

<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
class Decimal extends AbstractMapping
{
    /**
     * @param mixed $value
     * @return float
     */
    public function transformToPHP($value)
    {
        return (double)$value;
    }

    public function transformToCompare($value)
    {
        return (float)$value;
    }
}

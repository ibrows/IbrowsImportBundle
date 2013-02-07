<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
class Double extends Float
{
    /**
     * @param mixed $value
     * @return float
     */
    public function transformToPHP($value)
    {
        return (double)$value;
    }
}
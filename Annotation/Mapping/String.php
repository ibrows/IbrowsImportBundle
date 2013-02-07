<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
class String extends AbstractMapping
{
    /**
     * @param mixed $value
     * @return string
     */
    public function transformToPHP($value)
    {
        return (string)$value;
    }
}
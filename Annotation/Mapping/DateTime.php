<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
class DateTime extends AbstractMapping
{
    /**
     * @param mixed $value
     * @return string
     */
    public function transformToPHP($value)
    {
        return new \DateTime($value);
    }
}
<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
class StringMap extends AbstractMapping
{
    /**
     * @param mixed $value
     * @return string
     */
    public function transformToPHP($value)
    {
        return (string) $value;
    }
}

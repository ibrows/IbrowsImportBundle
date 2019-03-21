<?php

namespace Ibrows\ImportBundle\Annotation\Identifier;

/**
 * @Annotation
 */
class Identifier implements IdentifierInterface
{
    public $getterName = null;

    /**
     * @return null|string
     */
    public function getGetterName()
    {
        return $this->getterName;
    }
}

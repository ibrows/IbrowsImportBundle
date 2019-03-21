<?php

namespace Ibrows\ImportBundle\Annotation\Method;

/**
 * @Annotation
 */
abstract class AbstractMethod implements MethodInterface
{
    protected $context = null;

    /* (non-PHPdoc)
     * @see Ibrows\ImportBundle\Annotation\Method.MethodInterface::getContext()
     */
    public function getContext()
    {
        return $this->context;
    }
}

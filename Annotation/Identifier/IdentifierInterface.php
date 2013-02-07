<?php

namespace Ibrows\ImportBundle\Annotation\Identifier;

use Ibrows\ImportBundle\Annotation\ResolveByImporterInterface;

interface IdentifierInterface extends ResolveByImporterInterface
{
    /**
     * @return null|string
     */
    public function getGetterName();
}
<?php

namespace Ibrows\ImportBundle\Annotation\Method;

use Ibrows\ImportBundle\Annotation\ResolveByImporterInterface;

interface MethodInterface extends ResolveByImporterInterface
{
    const
        CONTEXT_POST_BUILD = 'postBuild'
    ;

    /**
     * @return string
     */
    public function getContext();
}
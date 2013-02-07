<?php

namespace Ibrows\ImportBundle\Annotation\Method;

/**
 * @Annotation
 */
class PostBuild extends AbstractMethod
{
    protected $context = self::CONTEXT_POST_BUILD;
}
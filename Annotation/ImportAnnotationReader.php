<?php

namespace Ibrows\ImportBundle\Annotation;

use Ibrows\ImportBundle\Annotation\Identifier\IdentifierInterface;
use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;
use Ibrows\ImportBundle\Annotation\Method\MethodInterface;
use Ibrows\ImportBundle\Annotation\Compare\CompareInterface;

use Ibrows\AnnotationReader\AnnotationReader;

class ImportAnnotationReader extends AnnotationReader implements ImportAnnotationReaderInterface
{
    /**
     * @param mixed $entity
     * @return MappingInterface[]
     */
    public function getMappingAnnotations($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_MAPPING, self::SCOPE_PROPERTY);
    }

    /**
     * @param mixed $entity
     * @return IdentifierInterface[]
     */
    public function getIdentifierAnnotations($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_IDENTIFIER, self::SCOPE_PROPERTY);
    }

    /**
     * @param mixed $entity
     * @return MethodInterface[]
     */
    public function getMethodAnnotations($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_METHOD, self::SCOPE_METHOD);
    }

    /**
     * @param mixed $entity
     * @return CompareInterface[]
     */
    public function getCompareAnnotations($entity)
    {
       return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_COMPARE, self::SCOPE_PROPERTY);

    }
}

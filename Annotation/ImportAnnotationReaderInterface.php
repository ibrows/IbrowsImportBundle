<?php

namespace Ibrows\ImportBundle\Annotation;


interface ImportAnnotationReaderInterface extends AnnotationReaderInterface
{
    const
        ANNOTATION_TYPE_MAPPING = 'MappingInterface',
        ANNOTATION_TYPE_IDENTIFIER = 'IdentifierInterface',
        ANNOTATION_TYPE_COMPARE = 'CompareInterface',
        ANNOTATION_TYPE_METHOD = 'MethodInterface'
    ;

    /**
     * @param mixed $entity
     * @return IdentifierInterface[]
     */
    public function getIdentifierAnnotations($entity);

    /**
     * @param mixed $entity
     * @return MappingInterface[]
     */
    public function getMappingAnnotations($entity);

    /**
     * @param mixed $entity
     * @return MethodInterface[]
     */
    public function getMethodAnnotations($entity);

    /**
     * @param mixed $entity
     * @return CompareInterface[]
     */
    public function getCompareAnnotations($entity);
}
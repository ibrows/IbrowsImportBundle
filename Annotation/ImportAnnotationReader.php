<?php

namespace Ibrows\ImportBundle\Annotation;
use Ibrows\ImportBundle\Annotation\Mapping\MappingInterface;
use Ibrows\ImportBundle\Annotation\Identifier\IdentifierInterface;
use Ibrows\AnnotationReader\AnnotationReader;


class ImportAnnotationReader extends AnnotationReader implements ImportAnnotationReaderInterface
{

    /* (non-PHPdoc)
     * @see Ibrows\ImportBundle\Annotation.ImportAnnotationReaderInterface::getMappingAnnotations()
     */
    public function getMappingAnnotations($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_MAPPING, self::SCOPE_PROPERTY);
    }

    /* (non-PHPdoc)
     * @see Ibrows\ImportBundle\Annotation.ImportAnnotationReaderInterface::getIdentifierAnnotations()
     */
    public function getIdentifierAnnotations($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_IDENTIFIER, self::SCOPE_PROPERTY);
    }

    /* (non-PHPdoc)
     * @see Ibrows\ImportBundle\Annotation.ImportAnnotationReaderInterface::getMethodAnnotions()
     */
    public function getMethodAnnotations($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_METHOD, self::SCOPE_METHOD);
    }

    public function getCompareAnnotations($entity)
    {
       return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_COMPARE, self::SCOPE_PROPERTY);

    }

}

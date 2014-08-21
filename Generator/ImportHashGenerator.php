<?php
/**
 * Created by PhpStorm.
 * User: Faebeee
 * Date: 21.08.14
 * Time: 11:57
 */

namespace Ibrows\ImportBundle\Generator;


use Ibrows\ImportBundle\Annotation\ImportAnnotationReaderInterface;
use Ibrows\ImportBundle\Row\RowInterface;

class ImportHashGenerator {

    /**
     * @var ImportAnnotationReaderInterface
     */
    protected $annotationReader;

    function __construct($annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }


    public function generateFromEntity($entity){
        $string="";
        $mappingAnnotations = $this->annotationReader->getMappingAnnotations($entity);
        foreach($mappingAnnotations as $propertyName => $typeAnnotation){
            $method = $typeAnnotation->getGetterName() ?: 'get'.ucfirst($propertyName);
            $value = $entity->$method();
            $value = $typeAnnotation->transformToPHP($value);
            $string.=$propertyName.":".$value.",";
        }

        return sha1($string);
    }
} 
<?php

namespace Ibrows\ImportBundle;

use Ibrows\ImportBundle\Annotation\Compare\Exclude;

use Ibrows\ImportBundle\Annotation\Method\MethodInterface;
use Ibrows\ImportBundle\Annotation\Compare\CompareInterface;

use Ibrows\ImportBundle\Annotation\ImportAnnotationReaderInterface;

use Ibrows\ImportBundle\Row\RowInterface;
use Ibrows\ImportBundle\Result\ResultBag;

use Ibrows\ImportBundle\Exception\MethodNotFoundException;
use Ibrows\ImportBundle\Exception\NotAllRowsGivenException;
use Ibrows\ImportBundle\Exception\ImportIdentifierNotFoundException;
use Ibrows\ImportBundle\Exception\NoImportAnnotationsFoundException;

use Doctrine\ORM\EntityManager;

abstract class AbstractImporter implements ImporterInterface
{
    /**
     * @var ImportAnnotationReaderInterface
     */
    protected $annotationReader;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ResultBag
     */
    protected $resultBag = null;

    /**
     * @param ImportAnnotationReaderInterface $annotationReader
     * @return AbstractImporter|ImporterInterface
     */
    public function setAnnotationReader(ImportAnnotationReaderInterface $annotationReader){
        $this->annotationReader = $annotationReader;

        return $this;
    }

    /**
     * @param EntityManager $entityManager
     * @return AbstractImporter|ImporterInterface
     */
    public function setEntityManager(EntityManager $entityManager){
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @param ResultBag $resultBag
     * @return AbstractImporter
     */
    public function setResultBag(ResultBag $resultBag = null)
    {
        $this->resultBag = $resultBag;

        return $this;
    }

    /**
     * @return ResultBag
     */
    public function getResultBag()
    {
        if(null !== $this->resultBag){
            return $this->resultBag;
        }

        return $this->resultBag = new ResultBag();
    }

    /**
     * @param string $key of current row
     * @param RowInterface $row
     * @param $className
     */
    protected function buildAndCompareEntity($key, RowInterface $row, $className)
    {
        $resultBag = $this->getResultBag();

        $builtEntity = $this->buildEntity($key, $row, new $className());

        if(!$builtEntity){
            $resultBag->addSkipped();
            return;
        }

        $alreadyExistingEntity = $this->getAlreadyExistingEntity($builtEntity);

        if(!$alreadyExistingEntity){
            $resultBag->addNew($builtEntity);
            return;
        }

        $areSameEntities = $this->compareEntities($builtEntity, $alreadyExistingEntity);
        if(!$areSameEntities || (method_exists($alreadyExistingEntity, 'getDeletedAt') && $alreadyExistingEntity->getDeletedAt() !== null)){
            $resultBag->addChanged($this->buildEntity($key, $row, $alreadyExistingEntity, true));
        }else{
            $resultBag->addSkipped($alreadyExistingEntity);
        }
    }

    /**
     * @param string $key of current row
     * @param RowInterface $row
     * @param mixed $entity
     * @param bool $fromAlreadyExisting
     * @return mixed|null $entity
     * @throws NotAllRowsGivenException
     * @throws NoImportAnnotationsFoundException
     * @throws MethodNotFoundException
     */
    protected function buildEntity($key, RowInterface $row, $entity, $fromAlreadyExisting = false)
    {
        $mappingAnnotations = $this->annotationReader->getMappingAnnotations($entity);

        if(!$mappingAnnotations){
            throw new NoImportAnnotationsFoundException('No Import-Annotations on "'. get_class($entity) .'"');
        }
        foreach($row->getFields() as $field){
            $fieldName = $field->getName();
            $isMappingField = false;

            foreach($mappingAnnotations as $propertyName => $typeAnnotation){

                if($typeAnnotation->getFieldName() != $fieldName){
                    continue;
                }

                $method = $typeAnnotation->getSetterName() ?: 'set'.ucfirst($propertyName);
                if(!method_exists($entity, $method)){
                    throw new MethodNotFoundException('Method "'. $method .'" not found in "'. get_class($entity) .'" on rowkey '.$key);
                }

                $fieldValue = $field->getValue();
                if(((is_scalar($fieldValue) && trim($fieldValue)) || is_array($fieldValue) && count($fieldValue)) OR !$typeAnnotation->ignoreBlank()){
                    $value = $typeAnnotation->transformToPHP($fieldValue);
                    $entity->$method($value);
                }

                unset($mappingAnnotations[$propertyName]);
                $isMappingField = true;
            }
            /**
             * @todo setData is too static
             */
            if(false === $isMappingField && method_exists($entity, 'setData')){
                $entity->setData($field->getName(), $field->getValue());
            }
        }

        if(count($mappingAnnotations) > 0){
            throw new NotAllRowsGivenException('Not all Mapping-Rows for Entity "'. get_class($entity) .'" on rowkey "'.$key .'" found: "'. implode('", "', array_keys($mappingAnnotations)) .'"');
        }

        $methodAnnotations = $this->annotationReader->getMethodAnnotations($entity);
        $this->invokeMethodCallbacks($methodAnnotations, MethodInterface::CONTEXT_POST_BUILD, $key, $entity, $fromAlreadyExisting);

        return $entity;
    }

    /**
     * @param MethodInterface[] $methodAnnotations
     * @param string $context
     * @param string $key
     * @param mixed $entity
     * @param bool $fromAlreadyExisting
     */
    protected function invokeMethodCallbacks(array $methodAnnotations, $context, $key, $entity, $fromAlreadyExisting)
    {
        foreach($methodAnnotations as $methodName => $annotation){
            if($annotation->getContext() == $context){
                $entity->$methodName($key, $fromAlreadyExisting);
            }
        }
    }

    /**
     * @param $entity
     * @return null|object
     * @throws ImportIdentifierNotFoundException
     * @throws MethodNotFoundException
     */
    protected function getAlreadyExistingEntity($entity)
    {
        foreach($this->getIdentifiersForEntity($entity) as $propertyName => $searchValue){
            if($searchValue){
                $alreadyExistingEntity = $this->entityManager->getRepository(get_class($entity))->findOneBy(array(
                    $propertyName => $searchValue
                ));

                if($alreadyExistingEntity){
                    return $alreadyExistingEntity;
                }
            }
        }
        return null;
    }

    protected function getIdentifiersForEntity($entity){
        $ids = array();
        $identifierTypeAnnotations = $this->annotationReader->getIdentifierAnnotations($entity);

        foreach($identifierTypeAnnotations as $propertyName => $identifierAnnotation){
            $method = $identifierAnnotation->getGetterName() ?: 'get'.ucfirst($propertyName);

            if(!method_exists($entity, $method)){
                throw new MethodNotFoundException('Method "'. $method .'" not found in "'. get_class($entity) .'"');
            }

            $searchValue = $entity->$method();
            $ids[$propertyName] = $searchValue;
        }

        if(!$identifierTypeAnnotations){
            throw new ImportIdentifierNotFoundException('Need IdentifierAnnotation on "'. get_class($entity) .'"');
        }
        return $ids;
    }

    /**
     * @param $builtEntity
     * @param $alreadyExisting
     * @return bool
     */
    protected function compareEntities($builtEntity, $alreadyExisting)
    {
        $mappingAnnotationsA = $this->annotationReader->getMappingAnnotations($builtEntity);
        $mappingAnnotationsB = $this->annotationReader->getMappingAnnotations($alreadyExisting);

        foreach($this->annotationReader->getCompareAnnotations($builtEntity) as $propertyName => $annotation){
            if($annotation instanceof Exclude){
                unset($mappingAnnotationsA[$propertyName]);
            }else{
                $mappingAnnotationsA[$propertyName] = $annotation;
            }
        }

        foreach($this->annotationReader->getCompareAnnotations($alreadyExisting) as $propertyName => $annotation){
            if($annotation instanceof Exclude){
                unset($mappingAnnotationsB[$propertyName]);
            }else{
                $mappingAnnotationsB[$propertyName] = $annotation;
            }
        }

        $compareValuesA = $this->getCompareValues($builtEntity, $mappingAnnotationsA);
        $compareValuesB = $this->getCompareValues($alreadyExisting, $mappingAnnotationsB, true);

        return $compareValuesA === $compareValuesB;
    }

    /**
     * @param mixed $entity
     * @param CompareInterface[] $annotations
     * @param bool $transformValues
     * @return array
     * @throws MethodNotFoundException
     */
    protected function getCompareValues($entity, $annotations, $transformValues = false)
    {
        $compareValues = array();

        foreach($annotations as $propertyName => $annotation){
            $method = $annotation->getGetterName() ?: 'get'.ucfirst($propertyName);

            if(!method_exists($entity, $method)){
                throw new MethodNotFoundException('Method "'. $method .'" not found in "'. get_class($entity) .'"');
            }

            $value = $entity->$method();
            if(true === $transformValues){
                $value = $annotation->transformToCompare($value);
            }

            $compareValues[$propertyName] = $value;
        }

        return $compareValues;
    }
}
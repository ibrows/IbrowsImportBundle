<?php

namespace Ibrows\ImportBundle;

use Ibrows\ImportBundle\Exception\MethodNotFoundException;

abstract class BulkImporter extends AbstractImporter
{
    protected $identifiers = array();
    protected $identifiersClass = '';
    protected $inserts = array();
    protected $updates = array();
    protected $dbIdentifier = 'id';
    protected $dbIdentifierGetter = 'getId';
    protected $alias = 'e';
    protected $stepSize = 0;


    protected function importRow($index, $row, $className)
    {
        $builtEntity = $this->buildEntity($index, $row, new $className());
        $arr = $this->getAlreadyExisting($builtEntity);
        if($arr){
            $this->update($builtEntity, $arr[$this->getDbIdentifier()]);
        }else{
            $this->insert($builtEntity);
        }
    }

    public function resetIdentifier(){
        $this->identifiers = array();
        $this->identifiersClass = '';
    }

    public function flush(){
        $this->flushUpdates();
        $this->flushInserts();
    }


    protected function update($entity, $id){
        $this->updates[$id] = $entity;
        if($this->getStepSize() !== 0 && sizeof($this->updates)>$this->getStepSize()){
            $this->flushUpdates();
        }
    }

    protected function flushUpdates(){
        $current = current($this->updates);
        if(!$current){
            return false;
        }
        $count = count($this->updates);
        $class = get_class($current);
        $ids = array_keys($this->updates);
        $existingEntities = $this->entityManager->getRepository($class)->findBy(array('id'=>$ids));
        foreach($existingEntities as $entity){
            $method = $this->getDbIdentifierGetter();
            $merged = $this->merge($entity,  $this->updates[$entity->$method()]);
            $this->entityManager->persist($merged);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
        $this->updates = array();
        return $count;
    }


    protected function insert($entity){
        $this->inserts[] = $entity;
        if($this->getStepSize() !== 0 && sizeof($this->inserts)>=$this->getStepSize()){
            $this->flushInserts();
        }
    }

    protected function flushInserts(){
        $count = count($this->inserts);
        if($count==0){
            return false;
        }
        foreach($this->inserts as $entity){
            $this->entityManager->persist($entity);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
        $this->inserts = array();
        return $count;
    }

    protected function merge($existing, $new){
        $mappingAnnotations = $this->annotationReader->getMappingAnnotations($existing);
        foreach($mappingAnnotations as $propertyName => $typeAnnotation){
            $method = $typeAnnotation->getSetterName() ?: 'set'.ucfirst($propertyName);
            if(!method_exists($existing, $method)){
                throw new MethodNotFoundException('Method "'. $method .'" not found in "'. get_class($existing) .'"');
            }
            $getMethod = $typeAnnotation->getGetterName() ?: 'get'.ucfirst($propertyName);
            if(!method_exists($new, $getMethod)){
                throw new MethodNotFoundException('Method "'. $getMethod .'" not found in "'. get_class($existing) .'"');
            }

            $value = $new->$getMethod();

            if($value !== null && $value !== '' ){
                if( $value instanceof \DateTime &&  $existing->$getMethod() == $value ){
                    continue; //avoid unnecessary updates on DateTimes
                }
                $existing->$method($value);
            }
        }
        return $existing;
    }



    protected function loadIdentifiers($entity, $force = false)
    {
        if (count($this->identifiers) > 0 && !$force && get_class($entity) == $this->identifiersClass) {
           return;
        }
        $this->identifiersClass = get_class($entity);
        $identifierTypeAnnotations = $this->annotationReader->getIdentifierAnnotations($entity);
        $alias = $this->getAlias();
        $select = $alias.'.'.$this->getDbIdentifier().',';
        $qb = $this->entityManager->getRepository( $this->identifiersClass)->createQueryBuilder($alias);
        foreach ($identifierTypeAnnotations as $propertyName => $identifierAnnotation) {
            $select .= "$alias.$propertyName,";
        }
        $select = substr($select, 0, -1);
        $qb->select($select);
        foreach ($qb->getQuery()->iterate() as $rows) {
            $row = array_shift($rows);
            foreach ($identifierTypeAnnotations as $propertyName => $identifierAnnotation) {
                $this->identifiers[$propertyName][$row[$propertyName]] = $row;
            }
        }
    }


    protected function getAlreadyExisting($entity)
    {
        $this->loadIdentifiers($entity);
        foreach($this->getIdentifiersForEntity($entity) as $propertyName => $searchValue){
            if(array_key_exists($searchValue,$this->identifiers[$propertyName])){
                return $this->identifiers[$propertyName][$searchValue];
            }
        }
        return false;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $dbIdentifier
     */
    public function setDbIdentifier($dbIdentifier)
    {
        $this->dbIdentifier = $dbIdentifier;
    }

    /**
     * @return string
     */
    public function getDbIdentifier()
    {
        return $this->dbIdentifier;
    }

    /**
     * @param string $dbIdentifierGetter
     */
    public function setDbIdentifierGetter($dbIdentifierGetter)
    {
        $this->dbIdentifierGetter = $dbIdentifierGetter;
    }

    /**
     * @return string
     */
    public function getDbIdentifierGetter()
    {
        return $this->dbIdentifierGetter;
    }


    /**
     * @param array $inserts
     */
    public function setInserts($inserts)
    {
        $this->inserts = $inserts;
    }

    /**
     * @return array
     */
    public function getInserts()
    {
        return $this->inserts;
    }

    /**
     * @param array $updates
     */
    public function setUpdates($updates)
    {
        $this->updates = $updates;
    }

    /**
     * @return array
     */
    public function getUpdates()
    {
        return $this->updates;
    }

    /**
     * @param int $stepSize
     */
    public function setStepSize($stepSize)
    {
        $this->stepSize = $stepSize;
    }

    /**
     * @return int
     */
    public function getStepSize()
    {
        return $this->stepSize;
    }



}

<?php

namespace Ibrows\ImportBundle\Tests\Stubs;

use Ibrows\ImportBundle\AbstractImporter;

class DummyImporter extends AbstractImporter
{
    private $existingEntities = [];

    /**
     * @param array $existingEntities
     * @return DummyImporter
     */
    public function setExistingEntities(array $existingEntities)
    {
        $this->existingEntities = $existingEntities;
        return $this;
    }

    public function process($data, $className)
    {
        foreach ($data as $i => $row) {
            $this->buildAndCompareEntity(
                $i,
                $row,
                $className
            );
            $this->getResultBag()->setCountProcessed($this->getResultBag()->countProcessed() + 1);
        }
    }

    private function isExistingEntity($propertyName, $searchValue)
    {
        return array_key_exists($propertyName, $this->existingEntities)
            && is_array($this->existingEntities[$propertyName])
            && array_key_exists($searchValue, $this->existingEntities[$propertyName]);
    }

    protected function getAlreadyExistingEntity($entity)
    {
        foreach ($this->getIdentifiersForEntity($entity) as $propertyName => $searchValue){
            if ($searchValue && $this->isExistingEntity($propertyName, $searchValue)) {
                return $this->existingEntities[$propertyName][$searchValue];
            }
        }
        return null;
    }
}

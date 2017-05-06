<?php

namespace Ibrows\ImportBundle\Tests\Stubs;

use Ibrows\ImportBundle\AbstractImporter;

class DummyImporter extends AbstractImporter
{
    public function process($data, $className)
    {
        foreach($data as $i => $row) {
            $this->buildAndCompareEntity(
                $i,
                $row,
                $className
            );
        }
    }

    protected function getAlreadyExistingEntity($entity)
    {
        // this method would call the entity manager, we're not interested in that here
        return null;
    }
}

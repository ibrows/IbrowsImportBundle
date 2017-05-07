<?php

namespace Ibrows\ImportBundle\Tests\Stubs;

use Ibrows\ImportBundle\Row\RowInterface;

class DummyImporterWithNullBuilder extends DummyImporter
{
    protected function buildEntity($key, RowInterface $row, $entity, $fromAlreadyExisting = false)
    {
        return null;
    }
}

<?php

namespace Ibrows\ImportBundle\Tests;

use Ibrows\ImportBundle\Generator\ImportHashGenerator;
use Ibrows\ImportBundle\Tests\Entities\EntityWithScalarTypes;

class ImportHashGeneratorTest extends AbstractTestBase
{
    public function testHashGeneration()
    {
        $hashGenerator = new ImportHashGenerator($this->createAnnotationReader());

        $entity = new EntityWithScalarTypes();
        $entity->setIntegerProperty(42);
        $entity->setFloatProperty((float)3.14);
        $entity->setDoubleProperty((double)2.71);
        $entity->setDecimalProperty((float)6.28);
        $entity->setStringProperty('ich bin ein berliner');

        $hash = $hashGenerator->generateFromEntity($entity);

        static::assertEquals('acf0e656a99f944fe41ddf6c636a64be7f73f2b5', $hash);
    }
}

<?php

namespace Ibrows\ImportBundle\Tests;

use Ibrows\ImportBundle\Tests\Entities\ImportableEntity;
use Ibrows\ImportBundle\Tests\Stubs\DummyRow;

class MappingTest extends AbstractTestBase
{

    public function testIntegerMapping()
    {
        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->process([
            new DummyRow([
                '42',
                '3.14',
                '2.71',
                '6.28',
                'ich bin ein berliner',
                '2017-01-23',
                'abc,def,xyz'
            ])
        ], ImportableEntity::class);

        static::assertCount(1, $dummyImporter->getResultBag()->getNew());

        /** @var ImportableEntity $newEntity */
        $newEntity = $dummyImporter->getResultBag()->getNew()[0];

        static::assertInstanceOf(ImportableEntity::class, $newEntity);

        static::assertInternalType('integer', $newEntity->getIntegerProperty());
        static::assertInternalType('float', $newEntity->getFloatProperty());
        static::assertInternalType('double', $newEntity->getDoubleProperty());
        static::assertInternalType('double', $newEntity->getDecimalProperty());
        static::assertInternalType('string', $newEntity->getStringProperty());
        static::assertInstanceOf(\DateTime::class, $newEntity->getDatetimeProperty());
        static::assertInternalType('string', $newEntity->getSimpleArrayProperty());


        static::assertEquals(42, $newEntity->getIntegerProperty());
        static::assertEquals(3.14, $newEntity->getFloatProperty());
        static::assertEquals(2.71, $newEntity->getDoubleProperty());
        static::assertEquals(6.28, $newEntity->getDecimalProperty());
        static::assertEquals('ich bin ein berliner', $newEntity->getStringProperty());
        static::assertEquals('2017-01-23', $newEntity->getDatetimeProperty()->format('Y-m-d'));
    }
}

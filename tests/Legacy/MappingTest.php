<?php

namespace Ibrows\ImportBundle\Tests\Legacy;

use Ibrows\ImportBundle\Tests\AbstractTestBase;
use Ibrows\ImportBundle\Tests\Legacy\Entities\SimpleImportableEntity;
use Ibrows\ImportBundle\Tests\Legacy\Entities\ImportableEntity;
use Ibrows\ImportBundle\Tests\Stubs\DummyRow;

class MappingTest extends AbstractTestBase
{
    protected function setUp()
    {
        if (PHP_MAJOR_VERSION >= 7) {
            $this->markTestSkipped('Legacy annotations won\'t work with PHP 7 or higher, skipping those tests');
        }
        parent::setUp();
    }

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

    /**
     * @expectedException \Ibrows\ImportBundle\Exception\NotAllRowsGivenException
     */
    public function testEmptyValueMapping()
    {
        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->process([
            new DummyRow([
                '',
                '',
                '',
                '',
                '',
                ''
            ])
        ], ImportableEntity::class);
    }

    public function testMappingWithExistingChangedEntity()
    {
        $existingEntity = new ImportableEntity();
        $existingEntity->setIntegerProperty(42);

        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->setExistingEntities([
            'integerProperty' => [
                42 => $existingEntity
            ]
        ]);
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

        static::assertEquals(0, $dummyImporter->getResultBag()->countSkipped());
        static::assertEquals(0, $dummyImporter->getResultBag()->countNew());
        static::assertEquals(1, $dummyImporter->getResultBag()->countChanged());
        static::assertEquals(1, $dummyImporter->getResultBag()->countProcessed());
    }

    public function testMappingWithExistingEqualEntity()
    {
        $existingEntity = new SimpleImportableEntity();
        $existingEntity->setIntegerProperty(42);
        $existingEntity->setFloatProperty((float)3.14);
        $existingEntity->setDoubleProperty((double)2.71);
        $existingEntity->setDecimalProperty((float)6.28);
        $existingEntity->setStringProperty('ich bin ein berliner');
        $existingEntity->setSimpleArrayProperty('abc,def,xyz');

        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->setExistingEntities([
            'integerProperty' => [
                42 => $existingEntity
            ]
        ]);
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
        ], SimpleImportableEntity::class);

        static::assertEquals(1, $dummyImporter->getResultBag()->countSkipped());
        static::assertEquals(0, $dummyImporter->getResultBag()->countNew());
        static::assertEquals(0, $dummyImporter->getResultBag()->countChanged());
        static::assertEquals(1, $dummyImporter->getResultBag()->countProcessed());
    }
}

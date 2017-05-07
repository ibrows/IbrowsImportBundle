<?php

namespace Ibrows\ImportBundle\Tests;

use Ibrows\ImportBundle\Tests\Entities\EntityWithMethodAnnotations;
use Ibrows\ImportBundle\Tests\Entities\ImportableEntity;
use Ibrows\ImportBundle\Tests\Entities\ImportableEntityWithNoIdentifier;
use Ibrows\ImportBundle\Tests\Entities\InvalidEntityMethodMissing;
use Ibrows\ImportBundle\Tests\Entities\InvalidEntityNoImportAnnotations;
use Ibrows\ImportBundle\Tests\Entities\SimpleImportableEntity;
use Ibrows\ImportBundle\Tests\Stubs\DummyImporterWithNullBuilder;
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

    public function testNullBuilderReturnHandling()
    {
        $dummyImporter = new DummyImporterWithNullBuilder();
        $dummyImporter->setAnnotationReader($this->createAnnotationReader());
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

        static::assertEquals(1, $dummyImporter->getResultBag()->countSkipped());
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

        static::assertCount(1, $dummyImporter->getResultBag()->getChanged());
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


    /**
     * @expectedException \Ibrows\ImportBundle\Exception\ImportIdentifierNotFoundException
     */
    public function testMappingOfNonIdentifierEntity()
    {
        $existingEntity = new ImportableEntityWithNoIdentifier();
        $existingEntity->setId(42);
        $existingEntity->setName('Fritz');

        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->setExistingEntities([
            'id' => [
                42 => $existingEntity
            ]
        ]);
        $dummyImporter->process([
            new DummyRow([
                'id' => '42',
                'name' => 'Hans',
            ])
        ], ImportableEntityWithNoIdentifier::class);
    }

    /**
     * @expectedException \Ibrows\ImportBundle\Exception\MethodNotFoundException
     */
    public function testMappingOfEntityWithNoSetters()
    {
        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->process([
            new DummyRow([
                'id' => '42',
                'name' => 'Hans',
            ])
        ], InvalidEntityMethodMissing::class);
    }

    /**
     * @expectedException \Ibrows\ImportBundle\Exception\NoImportAnnotationsFoundException
     */
    public function testMappingOfEntityWithNoAnnotations()
    {
        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->process([
            new DummyRow([
                'id' => '42',
                'name' => 'Hans',
            ])
        ], InvalidEntityNoImportAnnotations::class);
    }

    public function testMappingWithMethodAnnotations()
    {
        $dummyImporter = $this->createDummyImporter();
        $dummyImporter->process([
            new DummyRow([
                'id' => '42',
                'name' => 'Hans',
            ])
        ], EntityWithMethodAnnotations::class);

        static::assertEquals(1, $dummyImporter->getResultBag()->countNew());

        static::assertTrue($dummyImporter->getResultBag()->getNew()[0]->postBuildCallbackCalled);
    }
}

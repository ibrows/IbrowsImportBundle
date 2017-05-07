<?php

namespace Ibrows\ImportBundle\Tests;

use Ibrows\ImportBundle\Tests\Stubs\DummyRow;

class AbstractRowTest extends AbstractTestBase
{
    public function testFieldAccessor()
    {
        $row = new DummyRow([
            'testRow' => 23
        ]);

        static::assertTrue($row->has('testRow'));
        static::assertEquals(23, $row->get('testRow')->getValue());
    }

    public function testNonExistingFieldAccessor()
    {
        $row = new DummyRow([
            'testRow' => 23
        ]);

        static::assertFalse($row->has('discordia'));
        static::assertNull($row->get('discordia'));
    }
}

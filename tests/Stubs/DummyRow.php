<?php

namespace Ibrows\ImportBundle\Tests\Stubs;

use Ibrows\ImportBundle\Row\AbstractRow;

class DummyRow extends AbstractRow
{
    public function __construct(array $data)
    {
        $fields = [];
        foreach($data as $name => $value) {
            $fields[] = new DummyField((string)$name, $value);
        }

        $this->setFields($fields);
    }
}

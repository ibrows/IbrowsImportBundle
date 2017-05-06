<?php

namespace Ibrows\ImportBundle\Tests\Stubs;

use Ibrows\ImportBundle\Row\Field\AbstractField;

class DummyField extends AbstractField
{
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}

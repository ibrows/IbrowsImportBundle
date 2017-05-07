<?php

namespace Ibrows\ImportBundle\Tests\Entities;

use Ibrows\ImportBundle\Annotation as Import;

class InvalidEntityMethodMissing
{
    /**
     * @var int
     * @Import\Mapping\Field(type="integer", fieldName="id")
     * @Import\Compare\Field(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @Import\Mapping\Field(type="string", fieldName="name")
     * @Import\Compare\Field(type="string")
     */
    protected $name;
}

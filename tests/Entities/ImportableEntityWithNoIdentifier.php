<?php

namespace Ibrows\ImportBundle\Tests\Entities;

use Ibrows\ImportBundle\Annotation as Import;

class ImportableEntityWithNoIdentifier
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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ImportableEntityWithNoIdentifier
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ImportableEntityWithNoIdentifier
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}

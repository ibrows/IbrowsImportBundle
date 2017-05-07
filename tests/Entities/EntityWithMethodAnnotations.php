<?php

namespace Ibrows\ImportBundle\Tests\Entities;

use Ibrows\ImportBundle\Annotation as Import;

class EntityWithMethodAnnotations
{
    /**
     * @var int
     * @Import\Mapping\Field(type="integer", fieldName="id", ignoreNotExistent=true, ignoreBlank=true)
     * @Import\Compare\Field(type="integer")
     * @Import\Identifier\Identifier()
     */
    protected $id;

    /**
     * @var string
     * @Import\Mapping\Field(type="string", fieldName="name", ignoreNotExistent=true, ignoreBlank=true)
     * @Import\Compare\Field(type="string")
     */
    protected $name;

    public $postBuildCallbackCalled = false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return EntityWithMethodAnnotations
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
     * @return EntityWithMethodAnnotations
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @Import\Method\PostBuild()
     */
    public function postBuildCallback()
    {
        $this->postBuildCallbackCalled = true;
    }
}

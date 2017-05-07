<?php

namespace Ibrows\ImportBundle\Tests\Entities;

use Ibrows\ImportBundle\Annotation as Import;

class SimpleImportableEntity extends ImportableEntity
{
    /**
     * @var int
     * @Import\Mapping\Field(type="integer", fieldName="0")
     * @Import\Compare\Field(type="integer")
     * @Import\Identifier\Identifier()
     */
    protected $integerProperty;

    /**
     * @var float
     * @Import\Mapping\Field(type="float", fieldName="1")
     * @Import\Compare\Field(type="float")
     */
    protected $floatProperty;

    /**
     * @var double
     * @Import\Mapping\Field(type="double", fieldName="2")
     * @Import\Compare\Field(type="double")
     */
    protected $doubleProperty;

    /**
     * @var double
     * @Import\Mapping\Field(type="decimal", fieldName="3")
     * @Import\Compare\Field(type="decimal")
     */
    protected $decimalProperty;

    /**
     * @var string
     * @Import\Mapping\Field(type="string", fieldName="4")
     * @Import\Compare\Field(type="string")
     */
    protected $stringProperty;

    /**
     * @var \DateTime
     * @Import\Mapping\Field(type="dateTime", fieldName="5")
     * @Import\Compare\Exclude()
     */
    protected $datetimeProperty;

    /**
     * @var string
     * @Import\Mapping\Field(type="simpleArray", fieldName="6")
     * @Import\Compare\Field(type="simpleArray")
     */
    protected $simpleArrayProperty;
}

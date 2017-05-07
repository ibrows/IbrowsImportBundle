<?php

namespace Ibrows\ImportBundle\Tests\Entities;

use Ibrows\ImportBundle\Annotation as Import;
use Ibrows\ImportBundle\Tests\AbstractImportableEntity;

class ImportableEntity extends AbstractImportableEntity
{
    /**
     * @var int
     * @Import\Mapping\Field(type="integer", fieldName="0")
     */
    protected $integerProperty;

    /**
     * @var float
     * @Import\Mapping\Field(type="float", fieldName="1")
     */
    protected $floatProperty;

    /**
     * @var double
     * @Import\Mapping\Field(type="double", fieldName="2")
     */
    protected $doubleProperty;

    /**
     * @var double
     * @Import\Mapping\Field(type="decimal", fieldName="3")
     */
    protected $decimalProperty;

    /**
     * @var string
     * @Import\Mapping\Field(type="string", fieldName="4")
     */
    protected $stringProperty;

    /**
     * @var \DateTime
     * @Import\Mapping\Field(type="dateTime", fieldName="5")
     */
    protected $datetimeProperty;

    /**
     * @var string
     * @Import\Mapping\Field(type="simpleArray", fieldName="6")
     */
    protected $simpleArrayProperty;
}

<?php

namespace Ibrows\ImportBundle\Tests\Legacy\Entities;

use Ibrows\ImportBundle\Annotation as Import;
use Ibrows\ImportBundle\Tests\AbstractImportableEntity;

class ImportableEntity extends AbstractImportableEntity
{
    /**
     * @var int
     * @Import\Mapping\Integer(fieldName="0")
     * @Import\Compare\Integer()
     * @Import\Identifier\Identifier()
     */
    protected $integerProperty;

    /**
     * @var float
     * @Import\Mapping\Float(fieldName="1")
     * @Import\Compare\Float()
     */
    protected $floatProperty;

    /**
     * @var double
     * @Import\Mapping\Double(fieldName="2")
     * @Import\Compare\Double()
     */
    protected $doubleProperty;

    /**
     * @var double
     * @Import\Mapping\Decimal(fieldName="3")
     * @Import\Compare\Decimal()
     */
    protected $decimalProperty;

    /**
     * @var string
     * @Import\Mapping\String(fieldName="4")
     * @Import\Compare\String()
     */
    protected $stringProperty;

    /**
     * @var \DateTime
     * @Import\Mapping\DateTime(fieldName="5")
     * @Import\Compare\DateTime()
     */
    protected $datetimeProperty;

    /**
     * @var string
     * @Import\Mapping\SimpleArray(fieldName="6")
     * @Import\Compare\SimpleArray()
     */
    protected $simpleArrayProperty;
}

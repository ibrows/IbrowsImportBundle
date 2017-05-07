<?php

namespace Ibrows\ImportBundle\Tests\Legacy\Entities;

use Ibrows\ImportBundle\Annotation as Import;
use Ibrows\ImportBundle\Tests\AbstractImportableEntity;

class ImportableEntity extends AbstractImportableEntity
{
    /**
     * @var int
     * @Import\Mapping\Integer(fieldName="0")
     */
    protected $integerProperty;

    /**
     * @var float
     * @Import\Mapping\Float(fieldName="1")
     */
    protected $floatProperty;

    /**
     * @var double
     * @Import\Mapping\Double(fieldName="2")
     */
    protected $doubleProperty;

    /**
     * @var double
     * @Import\Mapping\Decimal(fieldName="3")
     */
    protected $decimalProperty;

    /**
     * @var string
     * @Import\Mapping\String(fieldName="4")
     */
    protected $stringProperty;

    /**
     * @var \DateTime
     * @Import\Mapping\DateTime(fieldName="5")
     */
    protected $datetimeProperty;

    /**
     * @var string
     * @Import\Mapping\SimpleArray(fieldName="6")
     */
    protected $simpleArrayProperty;
}

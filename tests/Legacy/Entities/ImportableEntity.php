<?php

namespace Ibrows\ImportBundle\Tests\Legacy\Entities;

use Ibrows\ImportBundle\Annotation as Import;

class ImportableEntity
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

    /**
     * @return int
     */
    public function getIntegerProperty()
    {
        return $this->integerProperty;
    }

    /**
     * @param int $integerProperty
     */
    public function setIntegerProperty($integerProperty)
    {
        $this->integerProperty = $integerProperty;
    }

    /**
     * @return float
     */
    public function getFloatProperty()
    {
        return $this->floatProperty;
    }

    /**
     * @param float $floatProperty
     */
    public function setFloatProperty($floatProperty)
    {
        $this->floatProperty = $floatProperty;
    }

    /**
     * @return float
     */
    public function getDoubleProperty()
    {
        return $this->doubleProperty;
    }

    /**
     * @param float $doubleProperty
     */
    public function setDoubleProperty($doubleProperty)
    {
        $this->doubleProperty = $doubleProperty;
    }

    /**
     * @return float
     */
    public function getDecimalProperty()
    {
        return $this->decimalProperty;
    }

    /**
     * @param float $decimalProperty
     */
    public function setDecimalProperty($decimalProperty)
    {
        $this->decimalProperty = $decimalProperty;
    }

    /**
     * @return string
     */
    public function getStringProperty()
    {
        return $this->stringProperty;
    }

    /**
     * @param string $stringProperty
     */
    public function setStringProperty($stringProperty)
    {
        $this->stringProperty = $stringProperty;
    }

    /**
     * @return mixed
     */
    public function getDatetimeProperty()
    {
        return $this->datetimeProperty;
    }

    /**
     * @param mixed $datetimeProperty
     */
    public function setDatetimeProperty($datetimeProperty)
    {
        $this->datetimeProperty = $datetimeProperty;
    }

    /**
     * @return string
     */
    public function getSimpleArrayProperty()
    {
        return $this->simpleArrayProperty;
    }

    /**
     * @param string $simpleArrayProperty
     */
    public function setSimpleArrayProperty($simpleArrayProperty)
    {
        $this->simpleArrayProperty = $simpleArrayProperty;
    }
}

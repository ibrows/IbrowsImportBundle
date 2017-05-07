<?php

namespace Ibrows\ImportBundle\Tests\Entities;

use Ibrows\ImportBundle\Annotation as Import;

class EntityWithScalarTypes
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
}

<?php

namespace Ibrows\ImportBundle\Tests;

abstract class AbstractImportableEntity
{
    /**
     * @var int
     */
    protected $integerProperty;

    /**
     * @var float
     */
    protected $floatProperty;

    /**
     * @var double
     */
    protected $doubleProperty;

    /**
     * @var double
     */
    protected $decimalProperty;

    /**
     * @var string
     */
    protected $stringProperty;

    /**
     * @var \DateTime
     */
    protected $datetimeProperty;

    /**
     * @var string
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

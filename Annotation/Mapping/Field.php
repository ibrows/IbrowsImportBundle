<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Field extends AbstractMapping
{
    /**
     * @Required
     * @var string
     */
    public $type;

    /**
     * @param array $data An array of key/value parameters
     *
     * @throws \BadMethodCallException
     */
    public function __construct(array $data)
    {
        if (isset($data['value'])) {
            $data['type'] = $data['value'];
            unset($data['value']);
        }

        foreach ($data as $key => $value) {
            $method = 'set'.str_replace('_', '', ucfirst($key));
            if (method_exists($this, $method)) {
                $this->$method($value);
            } elseif(property_exists($this, $key)) {
                $this->$key = $value;
            } else {
                throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".', $key, get_class($this)));
            }
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function transformToPHP($value)
    {
        $class = '\Ibrows\ImportBundle\Annotation\Mapping\\' . ucfirst($this->type);
        $obj = new $class();
        $obj->fieldName = $this->fieldName;
        $obj->getterName = $this->getterName;
        $obj->setterName = $this->setterName;
        $obj->ignoreBlank = $this->ignoreBlank;
        return $obj->transformToPHP($value);
    }

    public function transformToCompare($value)
    {
        $class = '\Ibrows\ImportBundle\Annotation\Mapping\\' . ucfirst($this->type);
        $obj = new $class();
        $obj->fieldName = $this->fieldName;
        $obj->getterName = $this->getterName;
        $obj->setterName = $this->setterName;
        $obj->ignoreBlank = $this->ignoreBlank;
        return $obj->transformToCompare($value);
    }
}

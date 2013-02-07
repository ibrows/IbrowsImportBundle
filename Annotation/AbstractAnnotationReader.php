<?php

namespace Ibrows\ImportBundle\Annotation;
use Doctrine\Common\Annotations\Reader;

abstract class AbstractAnnotationReader implements AnnotationReaderInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var array
     */
    protected static $cache = array();

    /**
     * @param Reader $annotationReader
     * @return AbstractAnnotationReader
     */
    public function setAnnotationReader(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;

        return $this;
    }

    /**
     * @param mixed $entity
     * @return array
     */
    public function getAnnotations($entity)
    {
        $reflectionClass = new \ReflectionClass($entity);
        $className = $reflectionClass->getName();

        if (isset(self::$cache[$className])) {
            return self::$cache[$className];
        }

        $annotations = array(
                self::SCOPE_CLASS => $this->getClassScopeAnnotations($reflectionClass),
                self::SCOPE_PROPERTY => $this->getPropertyScopeAnnotations($reflectionClass),
                self::SCOPE_METHOD => $this->getMethodScopeAnnotations($reflectionClass)
        );

        return self::$cache[$className] = $annotations;
    }

    /**
     * @param mixed $entity
     * @param string $type
     * @param string $scope
     * @return array
     */
    public function getAnnotationsByType($entity, $type, $scope)
    {
        $returnAnnotations = array();
        $annotations = $this->getAnnotations($entity);
        $scopeAnnotations = isset($annotations[$scope]) ? $annotations[$scope] : array();

        if ($scope === self::SCOPE_CLASS) {
            return isset($scopeAnnotations[$type]) ? reset($scopeAnnotations[$type]) : null;
        }

        foreach ($scopeAnnotations as $fieldName => $annotationTypes) {
            if (isset($annotationTypes[$type])) {
                $returnAnnotations[$fieldName] = reset($annotationTypes[$type]);
            }
        }

        return $returnAnnotations;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @return array
     */
    protected function getPropertyScopeAnnotations(\ReflectionClass $reflectionClass)
    {
        $annotations = array();

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            foreach ($this->annotationReader->getPropertyAnnotations($reflectionProperty) as $propertyAnnotation) {
                $fieldName = $reflectionProperty->getName();

                if (!isset($annotations[$fieldName])) {
                    $annotations[$fieldName] = array();
                }

                $reflectionAnnotation = new \ReflectionClass($propertyAnnotation);
                foreach ($reflectionAnnotation->getInterfaces() as $reflectionInterface) {
                    $explode = explode("\\", $reflectionInterface->getName());
                    $type = end($explode);

                    if (!isset($annotations[$fieldName][$type])) {
                        $annotations[$fieldName][$type] = array();
                    }

                    $annotations[$fieldName][$type][] = $propertyAnnotation;
                }
            }
        }

        $parentClass = $reflectionClass->getParentClass();
        if ($parentClass) {
            $annotations = array_merge_recursive($this->getPropertyScopeAnnotations($parentClass), $annotations);
        }

        return $annotations;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @return array
     */
    protected function getMethodScopeAnnotations(\ReflectionClass $reflectionClass)
    {
        $annotations = array();

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            foreach ($this->annotationReader->getMethodAnnotations($reflectionMethod) as $methodAnnotation) {
                $methodName = $reflectionMethod->getName();

                if (!isset($annotations[$methodName])) {
                    $annotations[$methodName] = array();
                }

                $reflectionAnnotation = new \ReflectionClass($methodAnnotation);
                foreach ($reflectionAnnotation->getInterfaces() as $reflectionInterface) {
                    $explode = explode("\\", $reflectionInterface->getName());
                    $type = end($explode);

                    if (!isset($annotations[$methodName][$type])) {
                        $annotations[$methodName][$type] = array();
                    }

                    $annotations[$methodName][$type][] = $methodAnnotation;
                }
            }
        }

        $parentClass = $reflectionClass->getParentClass();
        if ($parentClass) {
            $annotations = array_merge_recursive($this->getMethodScopeAnnotations($parentClass), $annotations);
        }

        return $annotations;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @return array
     */
    protected function getClassScopeAnnotations(\ReflectionClass $reflectionClass)
    {
        $annotations = array();

        foreach ($this->annotationReader->getClassAnnotations($reflectionClass) as $classAnnotation) {
            $reflectionAnnotation = new \ReflectionClass($classAnnotation);
            foreach ($reflectionAnnotation->getInterfaces() as $reflectionInterface) {
                $explode = explode("\\", $reflectionInterface->getName());
                $type = end($explode);

                if (!isset($annotations[$type])) {
                    $annotations[$type] = array();
                }

                $annotations[$type][] = $classAnnotation;
            }
        }

        $parentClass = $reflectionClass->getParentClass();
        if ($parentClass) {
            $annotations = array_merge_recursive($this->getClassScopeAnnotations($parentClass), $annotations);
        }

        return $annotations;
    }

    /**
     * @param string $className
     * @return \ReflectionProperty[]
     */
    protected function getReflectionProperties($className)
    {
        $reflectionClass = new \ReflectionClass($className);
        return $reflectionClass->getProperties();
    }
}

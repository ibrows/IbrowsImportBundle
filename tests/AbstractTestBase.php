<?php

namespace Ibrows\ImportBundle\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Ibrows\ImportBundle\Annotation\ImportAnnotationReader;
use Ibrows\ImportBundle\Tests\Stubs\DummyImporter;

class AbstractTestBase extends \PHPUnit_Framework_TestCase
{
    public function createAnnotationReader()
    {
        $reader = new AnnotationReader();
        $ibrowsAnnotationReader = new ImportAnnotationReader();
        $ibrowsAnnotationReader->setAnnotationReader($reader);

        return $ibrowsAnnotationReader;
    }

    public function createDummyImporter()
    {
        $dummyImporter = new DummyImporter();
        $dummyImporter->setAnnotationReader($this->createAnnotationReader());

        return $dummyImporter;
    }
}

<?php

namespace Ibrows\ImportBundle;

use Ibrows\ImportBundle\Annotation\ImportAnnotationReaderInterface;
use Ibrows\ImportBundle\Result\ResultBag;
use Doctrine\ORM\EntityManager;

interface ImporterInterface
{
    /**
     * @param $data
     * @param $className
     * @return void
     */
    public function process($data, $className);

    /**
     * @param ImportAnnotationReaderInterface $annotationReader
     * @return ImporterInterface
     */
    public function setAnnotationReader(ImportAnnotationReaderInterface $annotationReader);

    /**
     * @param EntityManager $entityManager
     * @return ImporterInterface
     */
    public function setEntityManager(EntityManager $entityManager);

    /**
     * @param ResultBag $resultBag
     * @return ImporterInterface
     */
    public function setResultBag(ResultBag $resultBag = null);

    /**
     * @return ResultBag
     */
    public function getResultBag();
}

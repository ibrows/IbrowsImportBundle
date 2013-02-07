<?php

namespace Ibrows\ImportBundle\Handler;

use Ibrows\ImportBundle\ImporterInterface;

use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ORM\EntityManager;

interface HandlerInterface
{
    /**
     * @param ImporterInterface $importer
     * @return AbstractHandler
     */
    public function setImporter(ImporterInterface $importer);

    /**
     * @param EntityManager $entityManager
     * @return AbstractHandler
     */
    public function setEntityManager(EntityManager $entityManager);

    /**
     * @param mixed $data
     * @param string $className
     * @param bool $flush
     * @param OutputInterface $output
     */
    public function handle($data, $className, $flush = false, OutputInterface $output = null);
}
<?php

namespace Ibrows\ImportBundle\Handler;

use Ibrows\ImportBundle\ImporterInterface;
use Ibrows\ImportBundle\Result\ResultBag;
use Ibrows\ImportBundle\Exception\MethodNotFoundException;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;

use Doctrine\ORM\EntityManager;

abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var ImporterInterface
     */
    protected $importer;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var boolean
     */
    protected $softdeletable = true;

    /**
     * @param bool $flag
     * @return AbstractHandler
     */
    public function setSoftDeletable($flag){
        $this->softdeletable = $flag;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSoftdeletable()
    {
        return $this->softdeletable;
    }

    /**
     * @param ImporterInterface $importer
     * @return AbstractHandler
     */
    public function setImporter(ImporterInterface $importer)
    {
        $this->importer = $importer;
        return $this;
    }

    /**
     * @param EntityManager $entityManager
     * @return AbstractHandler
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param $data
     * @param $className
     * @param $flush
     * @param OutputInterface $output
     * @throws MethodNotFoundException
     */
    protected function import($data, $className, $flush, OutputInterface $output = null)
    {
        if(!$output){
            $output = new NullOutput();
        }

        $em = $this->entityManager;

        if($this->softdeletable){
            $em->getFilters()->disable('softdeleteable');
            $output->writeln('<comment>---Disable softdeleteable---</comment>');
        }

        $output->writeln('<comment>---Start Import---</comment>');

        $importer = $this->importer;
        $resultBag = $importer->getResultBag();

        $importer->process($data, $className);

        $this->writeResultBagToOutput($output, $resultBag);

        if(true === $flush){

            $reflection = new \ReflectionClass($className);
            if ($this->softdeletable && (!$reflection->hasProperty('deletedAt') || !$reflection->hasMethod('setDeletedAt') || !$reflection->hasMethod('getDeletedAt'))) {
                throw new MethodNotFoundException(sprintf('It seems that the entity "%s" is not softdeleteable', $className));
            }

            $this->removeUnneededEntities($output, $resultBag);

            if ($resultBag->hasChanges()){

                $entities = array_merge($resultBag->getNew(), $resultBag->getChanged());
                foreach($entities as $entity){
                    if($this->softdeletable){
                        $entity->setDeletedAt(null);
                    }
                    $em->persist($entity);
                }

                $output->writeln('<info>Persisted ' . count($entities) . ' Entries</info>');
                $em->flush();
            }

        }

        if($this->softdeletable){
            $em->getFilters()->enable('softdeleteable');
        }
    }

    protected function removeUnneededEntities(OutputInterface $output, ResultBag $resultBag)
    {
        $em = $this->entityManager;

        $output->writeln('<error>Removing ' . $resultBag->countRemoving() . ' Entries</error>');
        foreach ($resultBag->getRemoving() as $entity){
            if(!$this->softdeletable || null === $entity->getDeletedAt()){
                $em->remove($entity);
            }
        }

        $em->flush();
    }

    /**
     * @param OutputInterface $output
     * @param ResultBag $resultBag
     */
    protected function writeResultBagToOutput(OutputInterface $output, ResultBag $resultBag)
    {
        $output->writeln('<comment>Processed: ' . $resultBag->countProcessed() . ' Entries</comment>');
        $output->writeln('<info>Changed: ' . $resultBag->countChanged() . ' Entries</info>');
        $output->writeln('<info>Skipped: ' . $resultBag->countSkipped() . ' Entries</info>');
        $output->writeln('<error>New: ' . $resultBag->countNew() . ' Entries</error>');
    }
}

<?php

namespace Ibrows\ImportBundle;

interface ImportableInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $selectLineNumber
     * @return ImportableInterface
     */
    public function setSelectLineNumber($selectLineNumber);

    /**
     * @return string
     */
    public function getSelectLineNumber();

    /**
     * @param int $numberOfRevisions
     * @return ImportableInterface
     */
    public function setNumberOfRevisions($numberOfRevisions);

    /**
     * @return int|null
     * @throws \RuntimeException
     */
    public function getNumberOfRevisions();

    /**
     * @param string $key
     * @param mixed $value
     * @return ImportableInterface
     */
    public function setData($key, $value);

    /**
     * @return array
     */
    public function getData();

    /**
     * @param \DateTime $createdAt
     * @return ImportableInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $deletedAt
     * @return ImportableInterface
     */
    public function setDeletedAt(\DateTime $deletedAt = null);

    /**
     * @return \DateTime
     */
    public function getDeletedAt();
}

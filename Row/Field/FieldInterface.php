<?php

namespace Ibrows\ImportBundle\Row\Field;

interface FieldInterface
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();
}
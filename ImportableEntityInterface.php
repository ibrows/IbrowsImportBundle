<?php
/**
 * Created by PhpStorm.
 * User: Faebeee
 * Date: 13.08.14
 * Time: 13:28
 */

namespace Ibrows\ImportBundle;


interface ImportableEntityInterface {
    public function getImportHash();
    public function setImportHash($hash = null);
    public function getUpdatedAt();
    public function setUpdatedAt(\DateTime $date = null);
} 
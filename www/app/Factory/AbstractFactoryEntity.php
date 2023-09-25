<?php

namespace App\Factory;

use App\Entity\Entity;
use stdClass;

interface AbstractFactoryEntity
{
    /**
     * @param stdClass $object
     * @param string $entityClass
     * @return Entity
     */
    public static function createEntityFromSdtClass(stdClass $object, string $entityClass) : Entity;
}
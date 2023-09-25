<?php

namespace App\Factory\Entity;

use App\Factory\AbstractFactoryEntity;
use stdClass;

class Entity implements AbstractFactoryEntity
{
    /**
     * @param stdClass $object
     * @param string $entityClass
     * @return \App\Entity\Entity
     */
    public static function createEntityFromSdtClass(stdClass $object, string $entityClass): \App\Entity\Entity
    {
        return new $entityClass($object);
    }
}
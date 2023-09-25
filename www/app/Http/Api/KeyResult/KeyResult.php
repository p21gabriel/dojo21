<?php

namespace App\Http\Api\KeyResult;

use App\Entity\KeyResult\KeyResultEntity;
use App\Factory\Entity\Entity;
use App\Http\Api\AbstractControllerApi;
use App\Repository\KeyResult\KeyResultRepository;
use App\Utils\Session;

class KeyResult extends AbstractControllerApi
{
    /**
     * @return void
     */
    public function save(): void
    {
        $body = $this->getParameters();

        $keyResultEntity = Entity::createEntityFromSdtClass($body, KeyResultEntity::class);

        (new KeyResultRepository())->save($keyResultEntity);

        $this->responseJson([
            'result' => 'success',
        ]);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $body = $this->getParameters();

        $keyResultEntity = Entity::createEntityFromSdtClass($body, KeyResultEntity::class);

        (new KeyResultRepository())->edit($keyResultEntity);

        $this->responseJson([
            'result' => 'success',
        ]);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $body = $this->getParameters();

        $keyResultRepository = new KeyResultRepository();

        $keyResultRepository->deleteOneByIdAndUser($body->key_result_id, Session::getUser()->getId());

        $this->responseJson([]);
    }
}
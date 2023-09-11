<?php

namespace App\Http\Api\KeyResult;

use App\Entity\KeyResult\KeyResultEntity;
use App\Http\Api\AbstractControllerApi;
use App\Repository\KeyResult\KeyResultRepository;
use App\Service\Session;

class KeyResultControllerApi extends AbstractControllerApi
{
    /**
     * @return void
     */
    public function save(): void
    {
        $body = $this->getParameters();

        $keyResultEntity = new KeyResultEntity();
        $keyResultEntity->setDescription($body->description);
        $keyResultEntity->setType($body->type);
        $keyResultEntity->setTitle($body->title);
        $keyResultEntity->setObjectiveId($body->objective_id);

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

        $keyResultEntity = new KeyResultEntity();
        $keyResultEntity->setId($body->key_result_id);
        $keyResultEntity->setDescription($body->description);
        $keyResultEntity->setType($body->type);
        $keyResultEntity->setTitle($body->title);
        $keyResultEntity->setObjectiveId($body->objective_id);

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
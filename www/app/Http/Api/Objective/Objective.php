<?php

namespace App\Http\Api\Objective;

use App\Entity\Objective\ObjectiveEntity;
use App\Factory\Entity\Entity;
use App\Http\Api\AbstractControllerApi;
use App\Repository\Objective\ObjectiveRepository;
use App\Utils\Session;

class Objective extends AbstractControllerApi
{
    /**
     * @return void
     */
    public function save(): void
    {
        $body = $this->getParameters();

        $objectiveEntity = Entity::createEntityFromSdtClass($body, ObjectiveEntity::class);
        $objectiveEntity->setUserId(Session::getUser()->getId());

        (new ObjectiveRepository())->save($objectiveEntity);

        $this->responseJson([]);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $body = $this->getParameters();

        $objectiveEntity = Entity::createEntityFromSdtClass($body, ObjectiveEntity::class);

        (new ObjectiveRepository())->edit($objectiveEntity);

        $this->responseJson([]);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $body = $this->getParameters();

        $objectiveRepository = new ObjectiveRepository();
        $objective = $objectiveRepository->findOneByIdAndUser($body->objective_id, Session::getUser()->getId());

        if(!$objective->getKeyResults()) {
           $objectiveRepository->deleteOneByIdAndUser($body->objective_id, Session::getUser()->getId());
        } else {
            $this->responseJson([
                'message' => 'Não é possível deletar objetivos que tenham resultados chaves associados!'
            ], 500);
        }

        $this->responseJson([]);
    }
}
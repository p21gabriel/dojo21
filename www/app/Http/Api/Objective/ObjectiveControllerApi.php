<?php

namespace App\Http\Api\Objective;

use App\Entity\Objective\ObjectiveEntity;
use App\Http\Api\AbstractControllerApi;
use App\Repository\Objective\ObjectiveRepository;
use App\Service\Session;

class ObjectiveControllerApi extends AbstractControllerApi
{
    /**
     * @return void
     */
    public function save(): void
    {
        $body = $this->getParameters();

        $objective = new ObjectiveEntity();
        $objective->setUserId(Session::getUser()->getId());
        $objective->setTitle($body->title);
        $objective->setDescription($body->description);

        (new ObjectiveRepository())->save($objective);

        $this->responseJson([]);
    }

    /**
     * @return void
     */
    public function update(): void
    {
        $body = $this->getParameters();

        $objective = new ObjectiveEntity();
        $objective->setId($body->objective_id);
        $objective->setTitle($body->title);
        $objective->setDescription($body->description);

        (new ObjectiveRepository())->edit($objective);

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
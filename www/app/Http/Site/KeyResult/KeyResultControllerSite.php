<?php

namespace App\Http\Site\KeyResult;

use App\Http\Site\AbstractControllerSite;
use App\Repository\Objective\ObjectiveRepository;
use App\Service\Session;

class KeyResultControllerSite extends AbstractControllerSite
{
    /**
     * @param array $args
     * @return string
     */
    public function add(array $args): string
    {
        $objective_id = reset($args);

        $objectiveRepository = new ObjectiveRepository();
        $objective = $objectiveRepository->findOneByIdAndUser($objective_id, Session::getUser()->getId());

        return $this->view('key_result/add.twig', compact('objective'));
    }

    /**
     * @param array $args
     * @return string
     */
    public function edit(array $args): string
    {
        $objectiveId = $args[0];
        $keyResultId = $args[1];

        $objectiveRepository = new ObjectiveRepository();
        $objective = $objectiveRepository->findOneByIdAndUser($objectiveId, Session::getUser()->getId());

        $keyResult = array_filter($objective->getKeyResults(), fn($item) => $item->getId() == $keyResultId);
        $keyResult = reset($keyResult);

        return $this->view('key_result/edit.twig', compact('objective', 'keyResult'));
    }

    /**
     * @param array $args
     * @return string
     */
    public function index(array $args): string
    {
        $objective_id = reset($args);

        $objectiveRepository = new ObjectiveRepository();

        $objective = $objectiveRepository->findOneByIdAndUser($objective_id, Session::getUser()->getId());
        $keyResults = $objective->getKeyResults();


        return $this->view('key_result/index.twig', compact('keyResults', 'objective'));
    }
}
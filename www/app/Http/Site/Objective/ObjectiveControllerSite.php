<?php

namespace App\Http\Site\Objective;

use App\Http\Site\AbstractControllerSite;
use App\Repository\Objective\ObjectiveRepository;
use App\Service\Session;

class ObjectiveControllerSite extends AbstractControllerSite
{
    /**
     * @return string
     */
    public function dashboard(): string
    {
        $objectiveModel = new ObjectiveRepository();

        $objectives = $objectiveModel->list(Session::getUser()->getId());

        return $this->view('objective/dashboard.twig', compact('objectives'));
    }

    /**
     * @return string
     */
    public function add(): string
    {
        return $this->view('objective/add.twig');
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $objectiveModel = new ObjectiveRepository();

        $objectives = $objectiveModel->list(Session::getUser()->getId());

        return $this->view('objective/index.twig', compact('objectives'));
    }

    /**
     * @param array $args
     * @return string
     */
    public function edit(array $args): string
    {
        $id = (int) reset($args);

        $userId = Session::getUser()->getId();

        $objectiveModel = new ObjectiveRepository();

        $objective = $objectiveModel->findOneByIdAndUser($id, $userId);

        return $this->view('objective/edit.twig', compact('objective'));
    }
}
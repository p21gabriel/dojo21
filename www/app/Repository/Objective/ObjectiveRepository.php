<?php

namespace App\Repository\Objective;

use App\Entity\Objective\ObjectiveEntity;
use App\Repository\AbstractRepository;
use App\Repository\KeyResult\KeyResultRepository;

class ObjectiveRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getEntity(): string
    {
        return ObjectiveEntity::class;
    }

    /**
     * @param ObjectiveEntity $objective
     * @return void
     */
    public function save(ObjectiveEntity $objective): void
    {
        $query = "INSERT INTO objective (user_id, title, description) values (:user_id, :title, :description)";

        $parameters = [
            ':user_id' => $objective->getUserId(),
            ':title' => $objective->getTitle(),
            ':description' => $objective->getDescription(),
        ];

        $this->insert($query, $parameters);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function list(int $userId): array
    {
        $query = "SELECT * FROM objective WHERE objective.user_id = :user_id";

        $parameters = [
            ':user_id' => $userId
        ];

        $objectives = $this->select($query, $parameters);

        $keyResultRepository = new KeyResultRepository();
        foreach ($objectives as $objective) {
            $objectiveId = $objective->getId();
            $keyResults = $keyResultRepository->list($objectiveId);

            $objective->setKeyResults($keyResults);
        }

        return $objectives;
    }

    /**
     * @param int $id
     * @param int $userId
     * @return ObjectiveEntity
     */
    public function findOneByIdAndUser(int $id, int $userId): ObjectiveEntity
    {
        $query = "SELECT * FROM objective WHERE objective.id = :objective_id AND objective.user_id = :user_id";

        $parameters = [
            ':objective_id' => $id,
            ':user_id' => $userId
        ];

        $objectives = $this->select($query, $parameters);

        $keyResultRepository = new KeyResultRepository();
        foreach ($objectives as $objective) {
            $objectiveId = $objective->getId();
            $keyResults = $keyResultRepository->list($objectiveId);

            $objective->setKeyResults($keyResults);
        }


        return reset($objectives);
    }

    /**
     * @param int $id
     * @param int $userId
     * @return void
     */
    public function deleteOneByIdAndUser(int $id, int $userId): void
    {
        $query = "DELETE FROM objective WHERE objective.id = :objective_id AND objective.user_id = :user_id";

        $parameters = [
            ':objective_id' => $id,
            ':user_id' => $userId
        ];

        $this->delete($query, $parameters);
    }

    /**
     * @param ObjectiveEntity $objective
     * @return void
     */
    public function edit(ObjectiveEntity $objective): void
    {
        $query = "UPDATE objective SET title = :title, description = :description WHERE objective.id = :objective_id ";

        $parameters = [
            ':objective_id' => $objective->getId(),
            ':title' => $objective->getTitle(),
            ':description' => $objective->getDescription(),
        ];

        $this->update($query, $parameters);
    }
}
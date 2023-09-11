<?php

namespace App\Repository\KeyResult;

use App\Entity\KeyResult\KeyResultEntity;
use App\Repository\AbstractRepository;

class KeyResultRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getEntity(): string
    {
        return KeyResultEntity::class;
    }

    /**
     * @param KeyResultEntity $keyResultEntity
     * @return void
     */
    public function save(KeyResultEntity $keyResultEntity): void
    {
        $query = "
            INSERT INTO
                key_result (objective_id, title, description, `type`)
            VALUES
                (:objective_id, :title, :description, :type)
        ";

        $parameters = [
            ':objective_id' => $keyResultEntity->getObjectiveId(),
            ':title' => $keyResultEntity->getTitle(),
            ':description' => $keyResultEntity->getDescription(),
            ':type' => $keyResultEntity->getType()
        ];

        $this->insert($query, $parameters);
    }

    /**
     * @param int $objectiveId
     * @return false|array
     */
    public function list(int $objectiveId): false|array
    {
        $query = "SELECT * FROM key_result WHERE key_result.objective_id = :objectiveId";

        $parameters = [
            ':objectiveId' => $objectiveId
        ];

        return $this->select($query, $parameters);
    }

    /**
     * @param KeyResultEntity $keyResultEntity
     * @return void
     */
    public function edit(KeyResultEntity $keyResultEntity): void
    {
        $query = "
            UPDATE
                key_result SET
            title = :title,
            description = :description,
            type = :type
            WHERE key_result.id = :key_result_id 
        ";

        $parameters = [
            ':key_result_id' => $keyResultEntity->getId(),
            ':title' => $keyResultEntity->getTitle(),
            ':description' => $keyResultEntity->getDescription(),
            ':type' => $keyResultEntity->getType(),
        ];

        $this->update($query, $parameters);
    }

    /**
     * @param int $id
     * @param int $userId
     * @return KeyResultEntity|null
     */
    public function findOneByIdAndUser(int $id, int $userId): ?KeyResultEntity
    {
        $query = "
            SELECT * FROM key_result
                INNER JOIN objective ON objective.id = key_result.objective_id
            WHERE 
                key_result.id = :key_result_id 
                AND objective.user_id = :user_id
        ";

        $parameters = [
            ':key_result_id' => $id,
            ':user_id' => $userId
        ];

        $keyResults = $this->select($query, $parameters);

        return reset($keyResults);
    }

    /**
     * @param int $id
     * @param int $userId
     * @return void
     */
    public function deleteOneByIdAndUser(int $id, int $userId): void
    {
        $query = "
            DELETE key_result FROM key_result
                INNER JOIN objective ON objective.id = key_result.objective_id
            WHERE
                key_result.id = :key_result_id
                AND objective.user_id = :user_id
       ";

        $parameters = [
            ':key_result_id' => $id,
            ':user_id' => $userId
        ];

        $this->delete($query, $parameters);
    }
}
<?php

namespace App\Entity\KeyResult;

use App\Entity\Entity;

class KeyResultEntity extends Entity
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var int
     */
    private int $type;

    /**
     * @var int
     */
    private int $objectiveId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getObjectiveId(): int
    {
        return $this->objectiveId;
    }

    /**
     * @param int $objectiveId
     */
    public function setObjectiveId(int $objectiveId): void
    {
        $this->objectiveId = $objectiveId;
    }

    /**
     * @return string
     */
    public function formatType(): string
    {
        return $this->getType() === 1 ? 'Milestone' : 'Porcentagem';
    }
}
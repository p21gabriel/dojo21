<?php

namespace App\Http\Api\User;

use App\Entity\Objective\ObjectiveEntity;
use App\Entity\User\UserEntity;
use App\Factory\Entity\Entity;
use App\Http\Api\AbstractControllerApi;
use App\Repository\User\UserRepository;

class User extends AbstractControllerApi
{
    /**
     * @return void
     */
    public function save(): void
    {
        $body = $this->getParameters();

        if (!$body->name || !$body->email || !$body->password) {
            $this->responseJson([
                'result' => 'error',
                'message' => 'Invalid name'
            ], 500);
        }

        $userEntity = Entity::createEntityFromSdtClass($body, UserEntity::class);

        (new UserRepository())->save($userEntity);

        $this->responseJson([
            'result' => 'success',
        ]);
    }
}
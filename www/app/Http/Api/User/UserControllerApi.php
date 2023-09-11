<?php

namespace App\Http\Api\User;

use App\Entity\User\UserEntity;
use App\Http\Api\AbstractControllerApi;
use App\Repository\User\UserRepository;

class UserControllerApi extends AbstractControllerApi
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

        $userEntity = new UserEntity();
        $userEntity->setName($body->name);
        $userEntity->setEmail($body->email);
        $userEntity->setPassword($body->password);

        (new UserRepository())->save($userEntity);

        $this->responseJson([
            'result' => 'success',
        ]);
    }
}
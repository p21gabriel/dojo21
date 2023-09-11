<?php

use App\Http\Api\KeyResult\KeyResultControllerApi;
use App\Http\Api\Login\LoginControllerApi;
use App\Http\Api\Objective\ObjectiveControllerApi;
use App\Http\Api\User\UserControllerApi;
use App\Http\Site\KeyResult\KeyResultControllerSite;
use App\Http\Site\Login\LoginControllerSite;
use App\Http\Site\Objective\ObjectiveControllerSite;
use App\Http\Site\User\UserControllerSite;

return [
    'GET' => [
        // Session
        '/login' => [LoginControllerSite::class, 'index'],
        '/logout' => [LoginControllerSite::class, 'logout'],
        '/signup' => [UserControllerSite::class, 'index'],

        // Objective
        '/objective' => [ObjectiveControllerSite::class, 'index'],
        '/objective/add' => [ObjectiveControllerSite::class, 'add'],
        '/objective/:id/edit' => [ObjectiveControllerSite::class, 'edit'],
        '/dashboard' => [ObjectiveControllerSite::class, 'dashboard'],

        // Key Result
        '/objective/:id/key_results' => [KeyResultControllerSite::class, 'index'],
        '/objective/:id/key_results/add' => [KeyResultControllerSite::class, 'add'],
        '/objective/:objective_id/key_results/:key_result_id/edit' => [KeyResultControllerSite::class, 'edit'],
    ],
    'POST' => [
        '/user/save' => [UserControllerApi::class, 'save'],
        '/user/login' => [LoginControllerApi::class, 'login'],

        '/objective/save' => [ObjectiveControllerApi::class, 'save'],
        '/objective/:id/delete' => [ObjectiveControllerApi::class, 'delete'],
        '/objective/update' => [ObjectiveControllerApi::class, 'update'],

        '/key_result/save' => [KeyResultControllerApi::class, 'save'],
        '/key_result/:id/delete' => [KeyResultControllerApi::class, 'delete'],
        '/key_result/update' => [KeyResultControllerApi::class, 'update'],
    ]
];
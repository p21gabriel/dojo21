<?php

use App\Http\Api\KeyResult\KeyResult as KeyResultApi;
use App\Http\Api\Login\Login as LoginApi;
use App\Http\Api\Objective\Objective as ObjectiveApi;
use App\Http\Api\User\User as UserApi;
use App\Http\Site\KeyResult\KeyResult as KeyResultSite;
use App\Http\Site\Login\Login as LoginSite;
use App\Http\Site\Objective\Objective as ObjectiveSite;
use App\Http\Site\User\User as UserSite;

return [
    'GET' => [
        // Session
        '/login' => [LoginSite::class, 'index'],
        '/logout' => [LoginSite::class, 'logout'],
        '/signup' => [UserSite::class, 'index'],

        // Objective
        '/objective' => [ObjectiveSite::class, 'index'],
        '/objective/add' => [ObjectiveSite::class, 'add'],
        '/objective/:id/edit' => [ObjectiveSite::class, 'edit'],
        '/dashboard' => [ObjectiveSite::class, 'dashboard'],

        // Key Result
        '/objective/:id/key_results' => [KeyResultSite::class, 'index'],
        '/objective/:id/key_results/add' => [KeyResultSite::class, 'add'],
        '/objective/:objective_id/key_results/:key_result_id/edit' => [KeyResultSite::class, 'edit'],
    ],
    'POST' => [
        '/user/save' => [UserApi::class, 'save'],
        '/user/login' => [LoginApi::class, 'login'],

        '/objective/save' => [ObjectiveApi::class, 'save'],
        '/objective/:id/delete' => [ObjectiveApi::class, 'delete'],
        '/objective/update' => [ObjectiveApi::class, 'update'],

        '/key_result/save' => [KeyResultApi::class, 'save'],
        '/key_result/:id/delete' => [KeyResultApi::class, 'delete'],
        '/key_result/update' => [KeyResultApi::class, 'update'],
    ]
];
<?php

namespace Goletter\Admin\Routes;

use Hyperf\HttpServer\Router\Router;

Router::addGroup('/api/admin', function () {
    // 角色
    Router::get('/roles/index', [\Goletter\Admin\Controller\RoleController::class, 'index']);
    Router::post('/roles/store', [\Goletter\Admin\Controller\RoleController::class, 'store']);
    Router::put('/roles/{id}', [\Goletter\Admin\Controller\RoleController::class, 'update']);
    Router::post('/roles/batch_delete', [\Goletter\Admin\Controller\RoleController::class, 'batchDelete']);

    // 权限
    Router::get('/permissions/perm_code', [\Goletter\Admin\Controller\PermissionController::class, 'permCode']);
    Router::get('/permissions/menu', [\Goletter\Admin\Controller\PermissionController::class, 'menu']);
    Router::get('/permissions/index', [\Goletter\Admin\Controller\PermissionController::class, 'index']);
    Router::post('/permissions/store', [\Goletter\Admin\Controller\PermissionController::class, 'store']);
    Router::put('/permissions/{id}', [\Goletter\Admin\Controller\PermissionController::class, 'update']);
});
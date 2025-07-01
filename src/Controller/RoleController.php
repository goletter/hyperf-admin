<?php

namespace Goletter\Admin\Controller;

use Donjan\Casbin\Enforcer;
use Goletter\Admin\Model\Permission;
use Goletter\Admin\Model\Role;
use Goletter\Admin\Request\RoleRequest;

class RoleController extends BaseController
{
    public function index()
    {
        $builder = Role::query()->filter($this->request->all())->latest()->paginate((int) $this->request->input('pageSize', 20));

        return $this->collection($builder);
    }

    public function store(RoleRequest $request)
    {
        $data = $request->all();
        $permissions = $request->input('permissions', []);
        unset($data['permissions']);
        $result = Role::create($data);
        $perms = Permission::whereIn('id', $permissions)->get();
        foreach ($perms as $value) {
            Enforcer::addPermissionForUser($result->name, $value->name);
        }

        return $this->success();
    }

    public function update(RoleRequest $request, int $id)
    {
        $data = $request->all();
        $permissions = $request->input('permissions', []);
        $result = Role::find($id);
        if (! $result) {
            return $this->fail(422, '请求资源不存在');
        }
        unset($data['permissions']);
        if (isset($data['name'])) {
            unset($data['name']);
        }
        $result->update($data);
        Enforcer::deletePermissionsForUser($result->name);
        $perms = Permission::whereIn('id', $permissions)->get();
        foreach ($perms as $value) {
            Enforcer::addPermissionForUser($result->name, $value->name);
        }

        return $this->success();
    }

    public function batchDelete()
    {
        $ids = $this->request->input('ids');

        if (count($ids) > 0) {
            Role::query()->whereIn('id', $ids)->delete();
        }

        return $this->success();
    }
}
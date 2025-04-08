<?php

namespace Goletter\Admin\Controller;

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
        $role = new Role();
        $role->fill($request->all());
        $role->save();

        return $this->success($role);
    }

    public function update(RoleRequest $request, int $id)
    {
        $role = Role::query()->where('id', $id)->first();
        $role->fill($request->all());
        $role->save();

        return $this->success();
    }
}
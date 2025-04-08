<?php
namespace Goletter\Admin\Controller;

use Goletter\Admin\Model\Permission;
use Goletter\Admin\Request\PermissionRequest;

class PermissionController extends BaseController
{
    public function index()
    {
        $builder = Permission::query()->where('parent_id', 0)->orderBy('type')->orderBy('parent_id')->orderBy('sort')->paginate((int) $this->request->input('pageSize', 20));
        $builder->load('children.children');

        return $this->collection($builder);
    }

    public function store(PermissionRequest $request)
    {
        $permission = new Permission();
        $permission->fill($request->all());
        $permission->save();

        return $this->success($permission);
    }

    public function update(PermissionRequest $request, int $id)
    {
        $permission = Permission::query()->where('id', $id)->first();
        $permission->fill($request->all());
        $permission->save();

        return $this->success($permission);
    }
}
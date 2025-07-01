<?php
namespace Goletter\Admin\Controller;

use Donjan\Casbin\Enforcer;
use Goletter\Admin\Model\Permission;
use Goletter\Admin\Request\PermissionRequest;
use Illuminate\Support\Arr;

class PermissionController extends BaseController
{
    public function index()
    {
        $builder = Permission::query()->where('parent_id', 0)->orderBy('type')->orderBy('parent_id')->orderBy('sort')->paginate((int) $this->request->input('pageSize', 20));
        $builder->load('children.children');

        return $this->collection($builder);
    }

    public function menu()
    {
        $data = [];
        $treeKeys = [];
        $subgrades = [];

        $user = auth()->guard('admins')->user();
        $roleId = Arr::get(Enforcer::getRolesForUser((string) $user->id), '0');
        $permissions = Enforcer::getPermissionsForUser((string) $roleId);
        $permCode = collect($permissions)->pluck('1');
        $permissions = Permission::query()->get();
        $userPermissions = Permission::query()->whereIn('name', $permCode)->get();
        Permission::$Ids = [];
        foreach ($userPermissions as $userPermission) {
            Permission::getPermIds($userPermission->id, $permissions);
        }

        $result = Permission::query()->whereIn('id', Permission::$Ids)->orderBy('level')->orderBy('type')->orderBy('parent_id')->orderBy('sort')->get();
        foreach ($result as $item) {
            $parentKey = Arr::get($treeKeys, $item->parent_id, 0);
            $subgrades[$item->parent_id][] = $item->id;

            $toItem = [
                'path' => $item->path,
                'name' => $item->name,
                'component' => $item->component,
                'meta' => [
                    'title' => $item->display_name,
                    'icon' => $item->icon,
                    'ignoreKeepAlive' => ! $item->keepalive,
                    'hideMenu' => ! $item->show,
                    'hideChildrenInMenu' => ! $item->child_show,
                ],
            ];
            if (! $item->parent_id) {
                $data[] = $toItem;
                $treeKeys[$item->id] = count($data) - 1;
            } else {
                $treeChildren = "{$parentKey}.children." . (count($subgrades[$item->parent_id]) - 1);
                $treeKeys[$item->id] = $treeChildren;
                Arr::set($data, $treeKeys[$item->id], $toItem);
            }
        }

        return $this->success($data);
    }

    public function permCode()
    {
        $user = auth()->guard('admins')->user();
        $roleId = Arr::get(Enforcer::getRolesForUser((string) $user->id), '0');
        $permissions = Enforcer::getPermissionsForUser((string) $roleId);
        $permCode = collect($permissions)->pluck('1');

        return $this->success($permCode);
    }

    public function store(PermissionRequest $request)
    {
        $data = $request->all();
        if (isset($data['parent_id'])) {
            $level = Permission::query()->where('id', $data['parent_id'])->value('level');
            $data['level'] = $level + 1;
        }
        $permission = new Permission();
        $permission->fill($data);
        $permission->save();

        return $this->success($permission);
    }

    public function update(PermissionRequest $request, int $id)
    {
        $permission = Permission::query()->where('id', $id)->first();

        $data = $request->all();
        if (isset($data['parent_id'])) {
            $level = Permission::query()->where('id', $data['parent_id'])->value('level');
            $data['level'] = $level + 1;
        }
        $permission->fill($data);
        $permission->save();

        return $this->success($permission);
    }
}
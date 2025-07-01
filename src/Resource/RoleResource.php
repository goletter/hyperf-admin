<?php

namespace Goletter\Admin\Resource;

use Donjan\Casbin\Enforcer;
use Goletter\Admin\Model\Permission;
use function Hyperf\Collection\collect;

class RoleResource extends Resource
{
    public function toArray(): array
    {
        $data = parent::toArray();

        $permissions = Enforcer::getPermissionsForUser($this->resource->name);
        $permCode = collect($permissions)->pluck('1');
        $data['permissions'] = Permission::query()->whereIn('name', $permCode)->pluck('id');

        return array_merge($data, []);
    }
}

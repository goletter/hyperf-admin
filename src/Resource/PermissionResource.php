<?php

namespace Goletter\Admin\Resource;

class PermissionResource extends Resource
{
    public function toArray(): array
    {
        $data = parent::toArray();

        return array_merge($data, []);
    }
}

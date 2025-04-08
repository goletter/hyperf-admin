<?php

namespace Goletter\Admin\Resource;

class RoleResource extends Resource
{
    public function toArray(): array
    {
        $data = parent::toArray();

        return array_merge($data, []);
    }
}

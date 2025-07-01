<?php

namespace Goletter\Admin\Resource;

class PermissionResource extends Resource
{
    public function toArray(): array
    {
        $data = parent::toArray();

        if (count($this->resource->children) > 0) {
            $data['children'] = PermissionResource::collection($this->whenLoaded('children'));
        } else {
            unset($data['children']);
        }

        return array_merge($data, []);
    }
}

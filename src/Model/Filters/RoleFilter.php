<?php

namespace Goletter\Admin\Model\Filters;

use Goletter\ModelFilter\ModelFilter;

class RoleFilter extends ModelFilter
{
    public function name($name): RoleFilter
    {
        return $this->where('name', 'like', "$name%");
    }
}

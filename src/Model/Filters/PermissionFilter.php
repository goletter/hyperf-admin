<?php
namespace Goletter\Admin\Model\Filters;

use Goletter\ModelFilter\ModelFilter;

class PermissionFilter extends ModelFilter
{
    public function name($name)
    {
        return $this->where('name', 'like', "$name%");
    }
}

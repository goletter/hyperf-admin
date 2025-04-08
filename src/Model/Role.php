<?php
namespace Goletter\Admin\Model;

use Goletter\ModelFilter\Filterable;

class Role extends Model
{
    use Filterable;

    protected array $fillable = [
        'name',
        'display_name',
    ];
}

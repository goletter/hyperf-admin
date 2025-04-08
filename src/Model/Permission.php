<?php
namespace Goletter\Admin\Model;

use Hyperf\Database\Model\Relations\HasMany;

class Permission extends Model
{
    protected array $fillable = [
        'parent_id',
        'level',
        'type',
        'name',
        'display_name',
        'icon',
        'component',
        'path',
        'sort',
        'is_ext',
        'status',
        'show',
        'child_show',
        'keepalive',
    ];

    public function child(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('parent_id')->orderBy('sort');
    }

    public function children(): HasMany
    {
        return $this->child()->with('children');
    }
}

<?php
namespace Goletter\Admin\Model;

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

    static public $Ids = [];
    public static function getPermIds($parentId, $permissions)
    {
        foreach ($permissions as $permission) {
            if ($parentId == $permission->id) {
                self::$Ids = array_unique(array_merge(self::$Ids, [$permission->id]));
                self::getPermIds($permission->parent_id, $permissions);
            }
        }
    }

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('parent_id')->orderBy('sort');
    }

    public function children()
    {
        return $this->child()->with('children');
    }
}

<?php

namespace Goletter\Admin\Model;

use Hyperf\DbConnection\Model\Model as BaseModel;

abstract class Model extends BaseModel
{
    protected array $guarded = [];
}
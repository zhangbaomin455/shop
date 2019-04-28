<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'test';
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}

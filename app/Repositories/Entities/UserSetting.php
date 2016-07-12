<?php

namespace App\Repositories\Entities;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{    
    /**
     * 與模型關聯的資料表。
     *
     * @var string
     */
    protected $table = 'user_settings';

    /**
     * 指定是否模型應該被戳記時間。
     *
     * @var bool
     */
    public $timestamps = true;
}

/* End of file UserSetting.php */
/* Location: .//home/tkb-user/projects/laravel/app/Repositories/Entities/UserSetting.php */

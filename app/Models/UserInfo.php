<?php


namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class UserInfo
 * @package App\Models
 */
class UserInfo extends Collection
{

    public function getUserInfoByOpenid($openid)
    {
        return DB::table('user_info')
            ->select(['code', 'nickname', 'sex', 'country', 'province', 'city', 'headimgurl'])
            ->where('openid', $openid)->get();
    }
}

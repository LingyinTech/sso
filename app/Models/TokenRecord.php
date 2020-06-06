<?php


namespace App\Models;


use Illuminate\Support\Facades\DB;

class TokenRecord
{
    public function getExpireRecordByToken($token)
    {
        return DB::table('token_record')
            ->select(['token', 'ticket', 'openid', 'redirect_uri', 'expireAt'])
            ->where('token', $token)
            ->where('expireAt', '>', time())
            ->first();
    }

    public function addRecord(array $data)
    {
        return DB::table('token_record')->insert($data);
    }
}

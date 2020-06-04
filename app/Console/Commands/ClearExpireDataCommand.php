<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearExpireDataCommand extends Command
{
    protected $name = 'clear:expireData';

    protected $description = 'clear expire data';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expireTime = time() - 86400;
        DB::table('token_record')->where('expireAt','<',$expireTime)->limit(5000)->delete();
    }
}

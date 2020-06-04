<?php

namespace App\Console\Commands;

use App\Events\WechatLoginEvent;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        event(new WechatLoginEvent('lingyin-5ed9142a8b81a', [
            'type' => 'login-success',
            'code' => md5('lingyin-5ed7db60945fb')
        ]));
    }
}

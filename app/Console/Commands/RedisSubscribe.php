<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interpreters\Factory;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to the Redis event channel';

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
        $this->info("pWire event listener started!");
        try {
            \Illuminate\Support\Facades\Redis::subscribe(['pwire-frontend'], function ($raw) {
                $this->info("Recieved Package");
                $message = json_decode($raw);
                if($message != null) {
                    $interpreter = Factory::make($packageType);
                    $interpreter->parse($raw);
                    if($interpreter->isValid()) {
                        $interpreter->run();
                        Log::info('Handled event of type '.$message->type.' from '.$message->sender);
                    }
                }
                $this->info('Finished Processing');
            });
        } catch (Exception $error) {
            $this->error('Redis connection timed out');
            return -1;
        }

    }
}

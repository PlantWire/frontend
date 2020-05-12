<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use App\HumidityMeasurement;
use App\HumiditySensor;

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
        \Illuminate\Support\Facades\Redis::subscribe(['pwire-frontend'], function ($raw) {
            $message = json_decode($raw);
            if($message->type == 'HumidityMeasurementResponse') {
                $measurement = new HumidityMeasurement($message->content->value);
                $measurement->sensor = HumiditySensor::where('uuid', $message->sender);
                $measurement->save();
            }
            $event = new Event();
            $event->content = utf8_encode($raw);
            $event->sensor = HumiditySensor::where('uuid', $message->sender);
            $event->save();
            Log::info('Handled event of type '.$message->type.' from '.$message->sender);
        });
    }
}

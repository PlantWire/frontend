<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\HumiditySensor;
use Illuminate\Support\Facades\Redis;

class RequestMeasurement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sensor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HumiditySensor $sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request = [
            'type' => 'HumidityMeasurementRequest',
            'target' => $this->sensor->uuid,
            'sender' => 'frontend',
            'content' => []
        ];
        Redis::publish('pwire-server', json_encode($request));
    }
}

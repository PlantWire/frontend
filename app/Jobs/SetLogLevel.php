<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Redis;

class SetLogLevel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $loglevel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $loglevel)
    {
        $this->loglevel = $loglevel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request = [
            'type' => 'SetSettingsCommand',
            'target' => 'all',
            'sender' => 'frontend',
            'content' => [
                'loglevel' => $this->loglevel
            ]
        ];
        Redis::publish('pwire-server', json_encode($request));
    }
}

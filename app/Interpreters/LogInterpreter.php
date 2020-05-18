<?php

namespace App\Interpreters;

use App\Event;
use Illuminate\Support\Facades\Log;

class LogInterpreter implements Interpreter {
    public $isValid = false;
    public $content = [
        'logType' => '',
        'message' => ''
    ];
    public $sender = 'unknown';
    public $reciever = 'frontend';

    public function parse(string $raw) : void {
        $decoded = json_decode($raw, JSON_OBJECT_AS_ARRAY);
        if($decoded != null) {

            $packet = array_change_key_case($decoded);
            if(array_key_exists('sender', $packet) && array_key_exists('content', $packet)) {
                $this->sender = $packet['sender'];

                $innerPacket = array_change_key_case($packet['content']);

                if(array_key_exists('logtype', $innerPacket) && array_key_exists('message', $innerPacket)) {
                    $this->content['logType'] = $innerPacket['logtype'];
                    $this->content['message'] = $innerPacket['message'];
                    $this->isValid = true;
                    return;
                }
            }
        }
        Log::Info('Error Parsing message via LogInterpreter', ['packet' => $raw]);
    }

    public function isValid() : bool {
        return $this->isValid;
    }

    public function toJson() : string {
        return json_encode([
            'type' => 'log',
            'sender' => $this->sender,
            'reciever' => $this->reciever,
            'content' => $this->content
        ]);
    }

    public function run() : void {
        $event = new Event();
        $event->content = $this->toJson();
        $event->save();
    }
}

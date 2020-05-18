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
        $this->isValid = false;
        $decoded = json_decode($raw, JSON_OBJECT_AS_ARRAY);
        if($decoded != null) {

            $packet = array_change_key_case($decoded);
            if(array_key_exists('sender', $packet) && array_key_exists('content', $packet)) {
                $this->sender = $packet['sender'];

                $innerPacket = array_change_key_case($packet['content']);

                if(array_key_exists('logtype', $innerPacket) && array_key_exists('message', $innerPacket)) {
                    if(in_array($innerPacket['logtype'], ['info', 'warn', 'err'])) {
                        $this->content['logType'] = $innerPacket['logtype'];
                        $this->content['message'] = $innerPacket['message'];
                        $this->isValid = true;
                        return;
                    } else {
                        Log::Info('Recieved Log packet with unknown log level', ['packet' => $raw]);
                    }
                }
            }
        }
        Log::Info('Error Parsing message via LogInterpreter', ['packet' => $raw]);
    }

    public function isValid() : bool {
        return $this->isValid;
    }

    public function toJson() : string {
        if($this->isValid) {
            return json_encode([
                'type' => 'Log',
                'sender' => $this->sender,
                'target' => $this->reciever,
                'content' => $this->content
            ]);
        } else {
            throw new \UnexpectedValueException('cannot convert invalid packet');
        }
    }

    public function run() : void {
        if($this->isValid) {
            $event = new Event();
            $event->content = $this->toJson();
            $event->save();
        } else {
            throw new \UnexpectedValueException('cannot execute invalid packet logic');
        }
    }
}

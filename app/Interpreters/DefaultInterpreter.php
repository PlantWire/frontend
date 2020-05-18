<?php

namespace App\Interpreters;

use App\Event;
use Illuminate\Support\Facades\Log;

class DefaultInterpreter implements Interpreter {
    public $isValid = false;
    public $content = [];
    public $sender = 'unknown';
    public $reciever = 'frontend';

    public function parse(string $raw) : void {
        $decoded = json_decode($raw, JSON_OBJECT_AS_ARRAY);
        if($decoded != null) {
            $packet = array_change_key_case($decoded);
            if(array_key_exists('sender', $packet) && array_key_exists('content', $packet)) {
                $this->sender = $packet['sender'];
                $this->content = $packet['content'];
                $this->isValid = true;
                return;
            }
        }
        Log::Info('Error Parsing message via DefaultInterpreter', ['packet' => $raw]);
    }

    public function isValid() : bool {
        return $this->isValid;
    }

    public function toJson() : string {
        if($this->$isValid) {
            return json_encode([
                'type' => 'default',
                'sender' => $this->sender,
                'reciever' => $this->reciever,
                'content' => $this->content
            ]);
        } else {
            throw new Exception('cannot convert invalid packet');
        }
    }

    public function run() : void {
        if($this->$isValid) {
            $event = new Event();
            $event->content = $this->toJson();
            $event->save();
        } else {
            throw new Exception('cannot execute invalid packet logic');
        }
    }
}

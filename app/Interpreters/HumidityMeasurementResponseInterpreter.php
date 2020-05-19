<?php

namespace App\Interpreters;

use App\Event;
use Illuminate\Support\Facades\Log;

use App\HumiditySensor;
use App\HumidityMeasurement;

class HumidityMeasurementResponseInterpreter implements Interpreter {
    public $isValid = false;
    public $content = [
        'value' => ''
    ];
    public $sender;
    public $reciever = 'frontend';

    public function parse(string $raw) : void {
        $this->isValid = false;
        $decoded = json_decode($raw, JSON_OBJECT_AS_ARRAY);
        if($decoded != null) {
            $packet = array_change_key_case($decoded);
            if(array_key_exists('sender', $packet)
              && array_key_exists('content', $packet)
              && array_key_exists('target', $packet)) {
                $this->reciever = $packet['target'];
                $this->sender = HumiditySensor::where('uuid', $packet['sender'])->first();
                if($this->sender != null) {
                    $innerPacket = array_change_key_case($packet['content']);

                    if(array_key_exists('value', $innerPacket)) {
                        if($innerPacket['value'] <= 100 && $innerPacket['value'] >= 0) {
                            $this->content['value'] = $innerPacket['value'];
                            $this->isValid = true;
                            return;
                        } else {
                            Log::Info('Humidiy measurement value out of range', ['packet' => $raw]);
                        }
                    }
                } else {
                    Log::Info('Humidiy measurement from unknown sensor recieved', ['packet' => $raw]);
                }
            }
        }
        Log::Info('Error Parsing message via HumidityMeasurementResponseInterpreter', ['packet' => $raw]);
    }

    public function isValid() : bool {
        return $this->isValid;
    }

    public function toJson() : string {
        if($this->isValid) {
            return json_encode([
                'type' => 'HumidityMeasurementResponse',
                'sender' => $this->sender->uuid,
                'target' => $this->reciever,
                'content' => $this->content
            ]);
        } else {
            throw new \UnexpectedValueException('invalid sensor');
        }
    }

    public function run() : void {
        if($this->isValid) {
            $measurement = new HumidityMeasurement();
            $measurement->value = $this->content['value'];
            $this->sender->measurements()->save($measurement);
            $event = new Event();
            $event->content = $this->toJson();
            $event->save();
        } else {
            throw new \UnexpectedValueException('invalid sensor');
        }
    }
}

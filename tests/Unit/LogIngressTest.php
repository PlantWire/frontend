<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Interpreters\LogInterpreter;

class LogIngressTest extends TestCase
{
    const validInput = '{"Type": "log","Sender": "uuid","Content": {"LogType": "warn","Message": "This is a test message"}}';
    const invalidJson = '{Type:"log",Sender:"uuid",Content:{LogType:"warn",Message:"This is a test message"}';
    const missingFields = '{Type:"log",Sender:"uuid",Content:{LogType:"warn"}}';
    const validOutput = '{"type":"log","sender":"uuid","reciever":"frontend","content":{"logType":"warn","message":"This is a test message"}}';

    use RefreshDatabase;

    public function testAcceptsCorrectInput()
    {
        $ingress = new LogInterpreter();
        $ingress->parse($this::validInput);
        $this->assertTrue($ingress->isValid());
    }

    public function testRefusesInvalidJson()
    {
        $ingress = new LogInterpreter();
        $ingress->parse($this::invalidJson);
        $this->assertFalse($ingress->isValid);
    }

    public function testRefusesIncompletePackets()
    {
        $ingress = new LogInterpreter();
        $ingress->parse($this::missingFields);
        $this->assertFalse($ingress->isValid);
    }

    public function testReturnsCorrectJson()
    {
        $ingress = new LogInterpreter();
        $ingress->parse($this::validInput);
        $this->assertJsonStringEqualsJsonString($this::validOutput, $ingress->toJson());
    }

    public function testCreatesEventOnRun()
    {
        $ingress = new LogInterpreter();
        $ingress->parse($this::validInput);
        $ingress->run();
        $this->assertDatabaseHas('events', [
            'content' => $this::validOutput
        ]);
    }
}

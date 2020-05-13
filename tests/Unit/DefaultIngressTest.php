<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Interpreters\DefaultInterpreter;

class DefaultIngressTest extends TestCase
{
    const validInput = '{"type": "aType", "sender": "a uuid or a string", "content": []}';
    const invalidJson = '{type: "aType", sender: "a uuid or a string", content: {}';
    const missingFields = '{type: "aType", content: {}}';
    const validOutput = '{"type": "default", "sender": "a uuid or a string", "reciever": "frontend", "content": []}';

    public function testAcceptsCorrectInput()
    {
        $ingress = new DefaultInterpreter();
        $ingress->parse($this::validInput);
        $this->assertTrue($ingress->isValid());
    }

    public function testRefusesInvalidJson()
    {
        $ingress = new DefaultInterpreter();
        $ingress->parse($this::invalidJson);
        $this->assertFalse($ingress->isValid);
    }

    public function testRefusesIncompletePackets()
    {
        $ingress = new DefaultInterpreter();
        $ingress->parse($this::missingFields);
        $this->assertFalse($ingress->isValid);
    }

    public function testReturnsCorrectJson()
    {
        $ingress = new DefaultInterpreter();
        $ingress->parse($this::validInput);
        $this->assertJsonStringEqualsJsonString($this::validOutput, $ingress->toJson());
    }

    public function testCreatesEventOnRun()
    {
        $ingress = new DefaultInterpreter();
        $ingress->parse($this::validInput);
        $ingress->run();
        $this->assertDatabaseHas('events', [
            'type' => 'default',
            'content' => $this::validOutput
        ]);
    }
}

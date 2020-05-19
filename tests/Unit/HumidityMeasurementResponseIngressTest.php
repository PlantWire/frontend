<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Interpreters\HumidityMeasurementResponseInterpreter;
use App\HumiditySensor;

class HumidityMeasurementResponseInterpreterTest extends TestCase
{
    const validInput = '{"Type": "HumidityMeasurementResponse", "Target": "frontend", "Sender": "8519f85c-01e1-4398-a142-184c34732393","Content": {"Value": 60}}';
    const unknownSensor = '{"Type": "HumidityMeasurementResponse", "Target": "frontend", "Sender": "bb669e29-6023-4d86-a3ad-04e3dd003546","Content": {"Value": 60}}';
    const outOfRangeUpper = '{"Type": "HumidityMeasurementResponse", "Target": "frontend", "Sender": "8519f85c-01e1-4398-a142-184c34732393","Content": {"Value": 60}}';
    const outOfRangeLower = '{"Type": "HumidityMeasurementResponse", "Target": "frontend", "Sender": "8519f85c-01e1-4398-a142-184c34732393","Content": {"Value": 60}}';
    const invalidJson = '{"Type": "HumidityMeasurementResponse", "Target": "frontend", "Sender": "8519f85c-01e1-4398-a142-184c34732393","Content": {"Value": 60}';
    const missingFields = '{"Type": "HumidityMeasurementResponse", "Target": "frontend", "Content": {"Value": 60}}';
    const validOutput = '{"type":"HumidityMeasurementResponse","target":"frontend","sender":"8519f85c-01e1-4398-a142-184c34732393","content":{"value": 60}}';
    use RefreshDatabase;

    public function testAcceptsCorrectInput()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::validInput);
        $this->assertTrue($ingress->isValid());
    }

    public function testRefusesUnknownSensors()
    {
        factory(HumiditySensor::class)->create()->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::unknownSensor);
        $this->assertFalse($ingress->isValid());
    }

    public function testRefusesOutOfRangeUpper()
    {
        factory(HumiditySensor::class)->create()->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::outOfRangeUpper);
        $this->assertFalse($ingress->isValid());
    }

    public function testRefusesOutOfRangeLower()
    {
        factory(HumiditySensor::class)->create()->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::outOfRangeLower);
        $this->assertFalse($ingress->isValid());
    }

    public function testThrowsOnInvalidRun()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::missingFields);
        $this->expectException(\UnexpectedValueException::class);
        $ingress->run();
    }

    public function testThrowsOnInvalidtoJson()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::missingFields);
        $this->expectException(\UnexpectedValueException::class);
        $ingress->toJson();
    }

    public function testRefusesInvalidJson()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::invalidJson);
        $this->assertFalse($ingress->isValid);
    }

    public function testRefusesIncompletePackets()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::missingFields);
        $this->assertFalse($ingress->isValid);
    }

    public function testReturnsCorrectJson()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::validInput);
        $this->assertJsonStringEqualsJsonString($this::validOutput, $ingress->toJson());
    }

    public function testCreatesEventOnRun()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::validInput);
        $ingress->run();
        $this->assertDatabaseHas('events', [
            'content' => $ingress->toJSON()
        ]);
    }

    public function testCreatesMeasurementOnRun()
    {
        factory(HumiditySensor::class)->create([
            'uuid' => '8519f85c-01e1-4398-a142-184c34732393',
        ])->make();
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::validInput);
        $ingress->run();
        $this->assertDatabaseHas('humidity_measurements', [
            'humidity_sensor_id' => $ingress->sender->id
        ]);
    }

    public function testStatusResetAfterSecondParse()
    {
        $ingress = new HumidityMeasurementResponseInterpreter();
        $ingress->parse($this::validInput);
        $ingress->parse($this::invalidJson);
        $this->assertFalse($ingress->isValid);
    }
}

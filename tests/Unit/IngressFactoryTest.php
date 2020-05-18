<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Interpreters\InterpreterFactory;

class IngressFactoryTest extends TestCase
{
    public function testReturnsDefaultFactoryOnBogusInput()
    {
        $factory = new InterpreterFactory();
        $this->assertInstanceOf(\App\Interpreters\DefaultInterpreter::class, InterpreterFactory::make('SuperAwesome'));
    }

    public function testReturnsFactoryLowercase()
    {
        $this->assertInstanceOf(\App\Interpreters\LogInterpreter::class, InterpreterFactory::make('log'));
    }

    public function testReturnsFactoryUppercase()
    {
        $factory = new InterpreterFactory();
        $this->assertInstanceOf(\App\Interpreters\LogInterpreter::class, InterpreterFactory::make('Log'));
    }

    public function testReturnsCorrectFactory()
    {
        $factory = new InterpreterFactory();
        $this->assertInstanceOf(\App\Interpreters\HumidityMeasurementResponseInterpreter::class, InterpreterFactory::make('HumidityMeasurementResponse'));
    }
}

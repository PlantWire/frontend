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
        $this->assertInstanceOf(\App\Interpreters\DefaultInterpreter::class, $factory->make('SuperAwesome'));
    }
}

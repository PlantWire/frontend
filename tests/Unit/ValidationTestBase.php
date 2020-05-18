<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Translation\MessageSelector;

class ValidationTestBase extends TestCase
{
    public function createValidator($attributes) {
        $translatorMock = Mockery::mock('Illuminate\Contracts\Translation\Translator');
        $translatorMock->shouldReceive([
            'get' => '',
        ]);

        return new Validator($translatorMock, $attributes, $this->getRules());
    }
}

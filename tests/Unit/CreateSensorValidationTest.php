<?php

namespace Tests\Unit;

use Illuminate\Contracts\Translation\MessageSelector;

class CreateSensorValidationTest extends ValidationTestBase
{
    private function createAttributes()
    {
        $attributes = [
            'uuid' => 'b9c3aab6-5c77-4fdd-b86a-6713f4eb17ae',
            'pin' => '1234',
            'name' => 'mySensor',
        ];

        return $attributes;
    }

    public function getRules() {
        $request = new \App\Http\Requests\StoreSensorRequest();
        $rules = $request->rules();
        return $rules;
    }


    public function testFormValidationPasses()
    {
        $validator = parent::createValidator($this->createAttributes());
        $this->assertTrue($validator->passes());
    }


    public function testNameIsMandatory()
    {
        $attributes = $this->createAttributes();
        $attributes['name']='';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUuidShouldNotContainNonHexadecimalCharacters()
    {
        $attributes = $this->createAttributes();
        $attributes['uuid']='616eb5e7-a209-407a-b55z-b38150346645';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUuidHasMinimumLength()
    {
        $attributes = $this->createAttributes();
        $attributes['uuid']='616eb5e7-a209-407a';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUuidHasMaximumLength()
    {
        $attributes = $this->createAttributes();
        $attributes['uuid']='616eb5e7-a209-407a-b55f-b38150346645-616eb5e7-a209-407a-b55f-b38150346645';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testPinHasMinimumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='-1';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testPinHasMaximumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='10000';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testPinMaximumIsAccepted()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='9999';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testPinMinimumIsAccepted()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='0';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testNameIsAlphanumeric()
    {
        $attributes = $this->createAttributes();
        $attributes['name']='H3110W0R1D';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testNameDoesNotAcceptNonAlphanumericCharacters()
    {
        $attributes = $this->createAttributes();
        $attributes['name']='H3110 W0R1D ^^';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }
}

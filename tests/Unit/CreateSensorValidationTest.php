<?php

namespace Tests\Unit;

class CreateSensorValidationTest extends ValidationTestBase
{

    private function createAttributes()
    {
        $faker = \Faker\Factory::create();

        $attributes = [
            'uuid' => $faker->uuid(),
            'pin' => '1234',
            'name' => 'mySensor',
        ];

        return $attributes;
    }

    public function getRules() {
        $request = new \App\Http\Requests\StoreHumiditySensorRequest();
        $rules = $request->rules();
        return $rules;
    }


    public function testCreateSensorFormValidationPasses()
    {
        $validator = parent::createValidator($this->createAttributes());
        $this->assertTrue($validator->passes());
    }


    public function testCreateSensorNameIsMandatory()
    {
        $attributes = $this->createAttributes();
        $attributes['name']='';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testCreateSensorUuidShouldNotContainNonHexadecimalCharacters()
    {
        $attributes = $this->createAttributes();
        $attributes['uuid']='616eb5e7-a209-407a-b55z-b38150346645';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testCreateSensorUuidHasMinimumLength()
    {
        $attributes = $this->createAttributes();
        $attributes['uuid']='616eb5e7-a209-407a';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testCreateSensorUuidHasMaximumLength()
    {
        $attributes = $this->createAttributes();
        $attributes['uuid']='616eb5e7-a209-407a-b55f-b38150346645-616eb5e7-a209-407a-b55f-b38150346645';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testCreateSensorPinHasMinimumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='-1';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testCreateSensorPinHasMaximumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='10000';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testCreateSensorPinMaximumIsAccepted()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='9999';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testCreateSensorPinMinimumIsAccepted()
    {
        $attributes = $this->createAttributes();
        $attributes['pin']='0';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testCreateSensorNameIsAlphanumeric()
    {
        $attributes = $this->createAttributes();
        $attributes['name']='H3110W0R1D';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testCreateSensorNameDoesNotAcceptNonAlphanumericCharacters()
    {
        $attributes = $this->createAttributes();
        $attributes['name']='H3110 W0R1D ^^';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }
}

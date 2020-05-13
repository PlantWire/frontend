<?php

namespace Tests\Unit;

use Illuminate\Contracts\Translation\MessageSelector;
use Carbon;

class StoreHumiditySensorValidationTest extends ValidationTestBase
{
    private function createAttributes()
    {
        $attributes = [
            'sensor_name' => 'mySensor',
            'alarm_threshold' => 50,
            'notes' => 'example',
            'measurement_interval_days' => 15,
            'measurement_interval_hours' => 15,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)
        ];

        return $attributes;
    }

    public function getRules() {
        $request = new \App\Http\Requests\StoreHumiditySensor();
        $rules = $request->rules();
        return $rules;
    }


    public function testUpdateSensorFormValidationPasses()
    {
        $validator = parent::createValidator($this->createAttributes());
        $this->assertTrue($validator->passes());
    }


    public function testUpdatsensorNameIsMandatory()
    {
        $attributes = $this->createAttributes();
        $attributes['sensor_name']='';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUpdateSensorNameIsAlphanumeric()
    {
        $attributes = $this->createAttributes();
        $attributes['sensor_name']='H3110W0R1D';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorNameDoesNotAcceptNonAlphanumericCharacters()
    {
        $attributes = $this->createAttributes();
        $attributes['sensor_name']='H3110 W0R1D ^^';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUpdateSensorAlarmThresholdIsOptional()
    {
        $attributes = $this->createAttributes();
        $attributes['alarm_threshold']=null;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }


    public function testUpdateSensorAlarmThresholdAcceptsMinimumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['alarm_threshold']=0;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorAlarmThresholdAcceptsMaximumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['alarm_threshold']=100;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorAlarmThresholdADoesNotAcceptNegativeValues()
    {
        $attributes = $this->createAttributes();
        $attributes['alarm_threshold']=-1;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUpdateSensorAlarmThresholdDoesNotAcceptTooLargeValues()
    {
        $attributes = $this->createAttributes();
        $attributes['alarm_threshold']=101;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUpdateSensorNotesIsOptional()
    {
        $attributes = $this->createAttributes();
        $attributes['notes']=null;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorNotesCanBeEmpty()
    {
        $attributes = $this->createAttributes();
        $attributes['notes']='';
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorMeasurementIntervalDaysIsOptional()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_interval_days']=null;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorMeasurementIntervalDaysCanBeZero()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_interval_days']=0;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }


    public function testUpdateSensorMeasurementIntervalHoursCanBeZero()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_interval_hours']=0;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorMeasurementIntervalDaysHasMaximumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_interval_days']=31;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUpdateSensorMeasurementIntervalHoursHasMaximumValue()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_interval_hours']=24;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

    public function testUpdateSensorMeasurementIntervalHoursIsOptional()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_interval_hours']=null;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorMeasurementIntervalStartIsOptional()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_interval_start']=null;
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorMeasurementStartAcceptsADateInTheFuture()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_start']=Carbon\Carbon::now()->addDays(2);
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->passes());
    }

    public function testUpdateSensorMeasurementStartDoesNotAcceptADateInThePast()
    {
        $attributes = $this->createAttributes();
        $attributes['measurement_start']=Carbon\Carbon::now()->subDays(2);
        $validator = parent::createValidator($attributes);
        $this->assertTrue($validator->fails());
    }

}

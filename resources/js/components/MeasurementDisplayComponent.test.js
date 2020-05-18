"use strict";

import { MeasurementHelper } from '../measurementHelper';

function getDummyMeasurements() {
    return [{"id":1,"value":23,"humidity_sensor_id":1,"created_at":"2020-04-08T18:45:54.000000Z","updated_at":"2020-04-08T18:45:54.000000Z"},{"id":2,"value":10,"humidity_sensor_id":1,"created_at":"2020-04-08T18:55:54.000000Z","updated_at":"2020-04-08T18:55:54.000000Z"},{"id":12,"value":10,"humidity_sensor_id":1,"created_at":"2020-04-08T19:55:54.000000Z","updated_at":"2020-04-08T18:55:54.000000Z"},{"id":13,"value":90,"humidity_sensor_id":1,"created_at":"2020-04-08T20:55:54.000000Z","updated_at":"2020-04-08T18:55:54.000000Z"},{"id":14,"value":80,"humidity_sensor_id":1,"created_at":"2020-04-08T21:55:54.000000Z","updated_at":"2020-04-08T18:55:54.000000Z"},{"id":35,"value":951,"humidity_sensor_id":1,"created_at":"2020-05-08T14:39:00.000000Z","updated_at":"2020-05-08T14:39:00.000000Z"},{"id":43,"value":901,"humidity_sensor_id":1,"created_at":"2020-05-08T14:39:00.000000Z","updated_at":"2020-05-08T14:39:00.000000Z"},{"id":28,"value":1447,"humidity_sensor_id":1,"created_at":"2020-05-08T14:39:00.000000Z","updated_at":"2020-05-08T14:39:00.000000Z"},{"id":23,"value":787,"humidity_sensor_id":1,"created_at":"2020-05-08T14:39:00.000000Z","updated_at":"2020-05-08T14:39:00.000000Z"},{"id":16,"value":1523,"humidity_sensor_id":1,"created_at":"2020-05-08T14:39:00.000000Z","updated_at":"2020-05-08T14:39:00.000000Z"}];
}

function getDummyMeasurement(created_at = new Date(), id=0, value=0, sensor_id=0) {
    return {"id":id,"value":value,"humidity_sensor_id":sensor_id,"created_at":created_at,"updated_at":created_at};
}

test('generate time ago string for current date', () => {
    expect(MeasurementHelper.generateTimeAgoString(new Date())).toBe("0 hours ago");
});

test('generate time ago string for one hour ago', () => {
    let date = new Date();
    date.setHours(date.getHours() - 1);
    expect(MeasurementHelper.generateTimeAgoString(date)).toBe("1 hours ago");
});

test('generate time ago string for two hours ago', () => {
    let date = new Date();
    date.setHours(date.getHours() - 2);
    expect(MeasurementHelper.generateTimeAgoString(date)).toBe("2 hours ago");
});

test('generate time ago string for two hours in the future', () => {
    let date = new Date();
    date.setHours(date.getHours() + 2);
    expect(MeasurementHelper.generateTimeAgoString(date)).toBe("-2 hours ago");
});

test('generate time ago string for one day ago', () => {
    let date = new Date();
    date.setDate(date.getDate()-1);
    expect(MeasurementHelper.generateTimeAgoString(date)).toBe("24 hours ago");
});

test('generate time ago string for three days ago', () => {
    let date = new Date();
    date.setDate(date.getDate()-3);
    expect(MeasurementHelper.generateTimeAgoString(date)).toBe("72 hours ago");
});

test('generate time ago string for four days ago', () => {
    let date = new Date();
    date.setDate(date.getDate()-4);
    expect(MeasurementHelper.generateTimeAgoString(date)).toBe("96 hours ago");
});

test('generate time ago string for five days ago', () => {
    let date = new Date();
    date.setDate(date.getDate()-5);
    expect(MeasurementHelper.generateTimeAgoString(date)).toBe("5 days ago");
});

test('last measurement returns undefined for empty array', () => {
    expect(MeasurementHelper.lastMeasurement([])).toBe(undefined);
});

test('last measurement for dummy measurements', () => {
    expect(MeasurementHelper.lastMeasurement(getDummyMeasurements()).id).toBe(16);
});

test('generate last update string for no measurements measurement for dummy measurements', () => {
    expect(MeasurementHelper.generateLastUpdateString([])).toBe("never");
});

test('generate last update string for no measurements measurement for dummy measurements', () => {
    expect(MeasurementHelper.generateLastUpdateString(getDummyMeasurements())).toContain("ago");
});

test('generate last update string for no measurements measurement for dummy measurements', () => {
    expect(MeasurementHelper.generateLastUpdateString(getDummyMeasurements())).toContain("ago");
});

test('compare measurement dates for equal measurements', () => {
    expect(MeasurementHelper.compareMeasurementDate(getDummyMeasurement(), getDummyMeasurement(new Date()))).toBe(0);
});

test('compare measurement dates for first date larger', () => {
    let date = new Date();
    date.setDate(date.getDate()+3);

    let firstDate = getDummyMeasurement(date);
    let secondDate = getDummyMeasurement(new Date());
    expect(MeasurementHelper.compareMeasurementDate(firstDate, secondDate)).toBeGreaterThan(0);
});

test('compare measurement dates for second date larger', () => {
    let date = new Date();
    date.setDate(date.getDate()+3);

    let firstDate = getDummyMeasurement(new Date());
    let secondDate = getDummyMeasurement(date);
    expect(MeasurementHelper.compareMeasurementDate(firstDate, secondDate)).toBeLessThan(0);
});

test('convert measurements returns empty result for empty input', () => {
    expect(MeasurementHelper.convertMeasurements([], 5).length).toBe(0);
});

test('convert measurements slides the input', () => {
    expect(MeasurementHelper.convertMeasurements(getDummyMeasurements(), 5).length).toBe(5);
});

test('convert measurements ignores max size if too large', () => {
    expect(MeasurementHelper.convertMeasurements(getDummyMeasurements(), 999).length).toBe(10);
});

test('convert measurements sorts the measurements max size if too large', () => {

    let firstDate = new Date();

    let secondDate = new Date();
    secondDate.setDate(secondDate.getDate()+1);

    let thirdDate = new Date();
    thirdDate.setDate(thirdDate.getDate()+2);

    let unsortedMeasurements = [
        getDummyMeasurement(thirdDate), getDummyMeasurement(firstDate), getDummyMeasurement(secondDate)
    ];

    expect(MeasurementHelper.convertMeasurements(unsortedMeasurements, 3)[0].created_at).toBe(firstDate);
});

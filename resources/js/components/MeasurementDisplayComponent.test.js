import { MeasurementHelper } from '../measurementHelper';

test('generate time ago string', () => {
    expect(MeasurementHelper.generateTimeAgoString(new Date())).toBe("1 hours ago");
});

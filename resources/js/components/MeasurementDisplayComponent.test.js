import { MeasurementHelper } from '../measurementHelper';

test('generate time ago string', () => {
    expect(MeasurementHelper.generateTimeAgoString(new Date())).toBe("0 hours ago");
});

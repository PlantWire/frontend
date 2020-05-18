"use strict";

export class MeasurementHelper {

    // max_amount_of_measurements_per_sensor_to_display: 15,

    static generateTimeAgoString(pastDate) {
        function calculateHoursAgo(pastDate) {
            let millisecondsPerHour = 1000 * 60 * 60;
            let millisecondsAgo = new Date() - new Date(pastDate);
            let hoursAgo = millisecondsAgo / millisecondsPerHour;
            return hoursAgo;
        }

        let hours = calculateHoursAgo(pastDate);
        let days = hours / 24;

        if (days > 4) {
            return Math.round(days) + " days ago";
        }
        return Math.round(hours) + " hours ago";
    }

    static lastMeasurement(measurements) {
        return measurements.slice(-1)[0];
    }

    static generateLastUpdateString(measurements) {
        let last = this.lastMeasurement(measurements);
        return (last === undefined) ? "never" : this.generateTimeAgoString(last.created_at);
    }

    static compareMeasurementDate(firstMeasurement, secondMeasurement) {
        if (firstMeasurement.created_at < secondMeasurement.created_at)
            return -1;
        if (firstMeasurement.created_at > secondMeasurement.created_at)
            return 1;
        return 0;
    }

    static convertMeasurements(measurements, maxAmountOfMeasurementsToDisplay) {
        return measurements
            .sort(this.compareMeasurementDate)
            .slice(Math.max(measurements.length - maxAmountOfMeasurementsToDisplay, 0));
    }
};

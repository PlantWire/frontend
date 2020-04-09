<template>
    <div class="column is-one-third">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    {{name}}
                </p>
                <a aria-label="hide" class="card-header-icon" href="#">
                    <span class="icon">
                        <i aria-hidden="true" class="fas fa-angle-up"></i>
                    </span>
                </a>
            </header>

            <div class="card-content">
                <div class="content">
                    <p class="subtitle is-4">{{notes}}</p>

                    <humidity-line-chart :chartdata="example" :options="options"></humidity-line-chart>
                    <br>
                    Last update: {{lastUpdate}}
                    <br>
                    Sensor created: {{sensorCreated}}
                    <br>

                    <span :class="isBelowAlarmThreshold ? 'tag is-danger' : 'tag'">{{ isBelowAlarmThreshold ? 'value below threshold' : 'everything is ok' }}</span>
                </div>
            </div>

            <footer class="card-footer">
                <a class="card-footer-item" href="#">Settings</a>
                <a class="card-footer-item" href="#">Details</a>
                <a class="card-footer-item" href="#">Measure Now</a>
            </footer>

        </div>
    </div>
</template>

<script>
    function generateTimeAgoString(pastDate) {
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

    function lastMeasurement(measurements) {
        return measurements.slice(-1)[0];
    }

    function generateLastUpdateString(measurements) {
        let last = lastMeasurement(measurements);
        return (last === undefined) ? "no measurements yet" : generateTimeAgoString(last.created_at)
    }

    function isBelowAlarmThreshold(measurements, alarmThreshold) {
        let last = lastMeasurement(measurements);
        if (last === undefined) {
            return false;
        }

        return alarmThreshold > last.value;
    }

    export default {
        props: ['sensor', 'measurements'],
        data() {
            return {
                name: this.sensor.name,
                alarmThreshold: this.sensor.alarmThreshold,
                notes: this.sensor.notes,
                lastUpdate: generateLastUpdateString(this.measurements),
                sensorCreated: generateTimeAgoString(this.sensor.created_at),
                isBelowAlarmThreshold: isBelowAlarmThreshold(this.measurements, this.sensor.alarm_threshold),

                example: {
                    labels: this.measurements.map(m => generateTimeAgoString(m.created_at)),
                    datasets: [
                        {
                            label: 'Moisture',
                            backgroundColor: 'RGB(255, 255, 255, 255)',
                            borderColor: 'RGBA(32, 156, 238, .6)',
                            data: this.measurements.map(m => m.value)
                        }
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            };
        },
        mounted() {
            // Do something useful with the data in the template
            console.dir(this.sensor)
        }
    }
</script>

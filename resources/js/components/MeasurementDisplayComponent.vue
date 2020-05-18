<template>
    <div class="column is-one-third">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    {{sensor.name + " "}}
                    <span :class="isBelowAlarmThreshold ? 'tag is-danger' : 'tag'">{{ isBelowAlarmThreshold ? 'low humidity!' : 'everything is ok' }}</span>
                </p>
            </header>

            <div class="card-content">
                <div class="content">
                    <p class="subtitle is-4">{{lastMeasurement}}</p>

                    <humidity-line-chart :chartData="chartdata" :options="options"></humidity-line-chart>
                    <br>
                    Last update: {{lastUpdate}}
                    <br>
                </div>
                <div class="modal" v-bind:class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-content">
                        <div class="modal-card">
                            <header class="modal-card-head">
                                <p class="modal-card-title">{{sensor.name}}</p>
                                <button class="delete" aria-label="close" v-on:click="modal['is-active'] = false"></button>
                            </header>
                            <section class="modal-card-body">
                              <humidity-line-chart :chartData="chartdata" :options="options"></humidity-line-chart>
                            </section>
                          </div>
                    </div>
                </div>
            </div>

            <footer class="card-footer">
                <a class="card-footer-item" v-bind:href="'/change-sensor/'+ sensor.id">Settings</a>
                <a class="card-footer-item" v-on:click="modal['is-active'] = true">Enlarge</a>
                <a class="card-footer-item" href="#">Measure Now</a>
            </footer>

        </div>
    </div>
</template>

<script>

    import { MeasurementHelper } from '../measurementHelper';

    export default {
        props: ['sensor', 'maxAmountOfMeasurementsToDisplay'],
        data() {
            return {
                modal: {
                    "is-active": false
                },
                chartdata: {
                    labels: undefined, //replaced when mounted() ist called
                    datasets: undefined
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
                },
                data: true
            };
        },
        computed: {
            lastUpdate: function () {
                return MeasurementHelper.generateLastUpdateString(this.sensor.measurements);
            },
            isBelowAlarmThreshold: function () {
                let last = MeasurementHelper.lastMeasurement(this.sensor.measurements);
                if (last === undefined) {
                    return false;
                }
                return this.sensor.alarm_threshold > last.value;
            },
            lastMeasurement: function () {
                let last = MeasurementHelper.lastMeasurement(this.sensor.measurements);
                return "Humidity: " + ((last === undefined) ? "?" : last.value);
            },

            chartData: function() {
                return this.chartdata.datasets.data = this.sensor.measurements.map(m => m.value);
            }
        }, mounted() {
            this.chartdata = {
                labels: MeasurementHelper.convertMeasurements(this.sensor.measurements).map(m => MeasurementHelper.generateTimeAgoString(m.created_at)),
                datasets: [
                    {
                        label: 'Humidity',
                        backgroundColor: 'RGB(255, 255, 255, 255)',
                        borderColor: 'RGBA(32, 156, 238, .6)',
                        data: MeasurementHelper.convertMeasurements(this.sensor.measurements, this.maxAmountOfMeasurementsToDisplay).map(m => m.value)
                    }
                ]
            }
        }
    }
</script>

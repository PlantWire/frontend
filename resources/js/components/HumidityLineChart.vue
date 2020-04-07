<script>
import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    props: ['chartdata', 'options'],
    mounted () {
        if(this.chartdata = undefined) {
            this.fillData();
        }
        this.renderChart(this.chartdata, this.options)
    },
    methods: {
        fillData () {
            this.chartdata = {
                labels: [this.getRandomInt(), this.getRandomInt()],
                datasets: [
                    {
                        label: 'Data One',
                        backgroundColor: '#f87979',
                        data: [this.getRandomInt(), this.getRandomInt()]
                    }, {
                        label: 'Data One',
                        backgroundColor: '#f87979',
                        data: [this.getRandomInt(), this.getRandomInt()]
                    }
                ]
            }
        },
        getRandomInt () {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5
        }
    }
}
</script>

<style>
</style>

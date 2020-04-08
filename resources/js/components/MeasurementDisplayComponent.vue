<template>
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">
              Tulip
            </p>
            <a href="#" class="card-header-icon" aria-label="hide">
              <span class="icon">
                <i class="fas fa-angle-up" aria-hidden="true"></i>
              </span>
            </a>
        </header>
        <div class="card-content">
            <div class="content">
              <humidity-line-chart :chartdata="example" :options="options"></humidity-line-chart>
              <br>
              Last update: <time datetime="2016-1-1">4 years ago</time>
            </div>
        </div>
        <footer class="card-footer">
            <a href="#" class="card-footer-item">Settings</a>
            <a href="#" class="card-footer-item">Details</a>
            <a href="#" class="card-footer-item">Measure Now</a>
        </footer>
    </div>
</template>

<script>
    export default {
        props: ['sensor'],
        data() {
            return {
                example: {
                    labels: ["4 days ago", "3 days ago",  "2 days ago",  "1 days ago", "4 hours ago", "2 hours ago", "1 hour ago"],
                    datasets: [
                        {
                            label: 'Humidity',
                            backgroundColor: 'RGB(255, 255, 255, 255)',
                            borderColor: 'RGBA(32, 156, 238, .6)',
                            data: [30, 98, 96, 45, 23, 12, 3, 0]
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
                                display:false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display:false
                            }
                        }]
                    }
                }
            };
        },
        mounted () {
            // Do something useful with the data in the template
            console.dir(this.sensor)
        }
    }
</script>

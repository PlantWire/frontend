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
              <humidity-line-chart></humidity-line-chart>
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

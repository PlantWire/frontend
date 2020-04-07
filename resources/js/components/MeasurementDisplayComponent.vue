<template>
    <div class="col-md-4">
        <div class="card mt-3">

            <div class="card-body">

                <h3 class="card-title">Tulip <span class="badge badge-info">!</span></h3>


                <h4 class="display-4">45</h4>

                <p class="card-text">A tulip doesn’t strive to impress anyone. It doesn’t struggle to be different than
                    a rose. It doesn’t have to. It is different. And there’s room in the garden for every flower. </p>

                <button type="button" class="btn btn-outline-primary btn-block">Measure now!</button>

                <button type="button" class="btn btn-outline-secondary btn-block">Show history</button>

            </div>

            <div class="card-footer">
                Last Update: 4 Hours ago
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

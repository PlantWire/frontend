<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ title }}</div>

                    <div class="card-body">
                        {{ description.text }}
                        <input type="text" v-model="description.text" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                description: {
                    text: "Hello World"
                },
                title: "Tulpen"
            };
        },
        mounted() {
            console.log('Component mounted.')
            window.setTimeout(() => {
                this.description.text = "Moin Welt";
            }, 2000);
        }
    }
</script>

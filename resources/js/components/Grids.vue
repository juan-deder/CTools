<template>
    <div class="grids">
        <div class="loading" v-if="loading">Loading</div>

        <div class="error" v-if="error">{{ error }}</div>

        <ul v-if="grids">
            <li v-for="grid in grids">{{ grid }}</li>
        </ul>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                loading: false,
                grids: [],
                error: null
            }
        },
        created() {
            return axios.get('api/grids?api_token=e3e78dafad3d43d0dba848a2c37480ea104414153ea9654938e77b06643bd759')
                .then(response => {
                    this.grids = response.data
                    this.error = null
                })
                .catch(error => {
                    this.error = error
                    this.girds = []
                })
        }
    }
</script>

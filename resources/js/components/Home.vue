<template>
    <div>
        <a href="" @click.prevent="user()">User</a>
    </div>
</template>
<script>
    export default {
        methods: {
            user () {
                axios.get('api/user').then(response => console.log(response))
            }
        }
    }
</script>

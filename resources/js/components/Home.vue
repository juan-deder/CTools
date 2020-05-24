<template>
    <div>
        <a href="" @click.prevent="login()">Login</a>
        <a href="" @click.prevent="logout()">Logout</a>
        <a href="" @click.prevent="user()">User</a>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                csrf_token: null
            }
        },
        methods: {
            login () {
                axios.post('api/login', {email: 'q@q', password: 'qwerqwer'})
                    .then(response =>
                        console.log(response)
                    )
            },
            user () {
                axios.get('api/user')
                    .then(response =>
                        console.log(response)
                    )
            },
            logout () {
                axios.post('api/logout')
                    .then(response =>
                        console.log(response)
                    )
            }
        }
    }
</script>

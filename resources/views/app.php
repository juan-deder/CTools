<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CGrid</title>
</head>
<body>
    <div id="app">
        <ul>
            <li><router-link to="/">Home</router-link></li>
            <li><router-link to="/grids">CGrid</router-link></li>
        </ul>
        <ul v-if="user">
            <li>{{ user.name }}</li>
            <li><a href="" @click.prevent="logout">Logout</a></li>
        </ul>
        <ul v-else>
            <li><a href="" @click.prevent="register">Register</a></li>
            <li><a href="" @click.prevent="login">Login</a></li>
        </ul>
        <router-view></router-view>
    </div>
    <script src="../js/app.js"></script>
</body>
</html>

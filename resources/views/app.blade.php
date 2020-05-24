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
            <li><router-link to="/grids">Grids</router-link></li>
        </ul>

        <router-view></router-view>
    </div>


    <script src="../js/app.js"></script>
</body>
</html>

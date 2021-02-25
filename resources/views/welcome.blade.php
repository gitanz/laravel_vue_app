<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    <title>{{env('APP_NAME')}}</title>
</head>
<body>
<script crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<header>
    <div id="app">

    </div>
</header>

<main class="flex-shrink-0">
    <div class="container">
        <p class="lead">

        </p>
    </div>
</main>


<script src="{{asset("js/app.js")}}"></script>
</body>
</html>

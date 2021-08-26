<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset("css/layout.css") }}">
</head>
<body class="bg-light">
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-dark text-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Miac</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-white" href="/">Main</a>
        <a class="p-2 text-white" href="/about">About</a>
    </nav>
    <a class="btn btn-warning" href="/login">Admin Panel</a>
</div>
    @yield('main_content')
</body>
    @yield('script_content')
</html>

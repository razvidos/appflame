<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{csrf_token()}}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title', 'Page')</title>
</head>
<body>
<div class="container px-3">
    <header class="border-bottom">
        <div class="row d-flex flex-wrap justify-content-center pt-3">
            <a href="/"
               class="col-auto d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4">Солом'яний Ігор Олександрович</span>
            </a>

            <ul class="col-auto nav nav-pills">
                <li class="nav-item"><a href="{{ route('book.index') }}" class="nav-link active" aria-current="page">Books</a></li>
                <li class="nav-item"><a href="{{ route('author.index') }}" class="nav-link active" aria-current="page">Authors</a></li>
            </ul>
        </div>
    </header>

</div>

<div class="container px-3">
    @yield('main-content', 'Default content')
</div>

</body>
</html>

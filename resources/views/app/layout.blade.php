<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="app_id" content="{{ env('DISCORD_KEY') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>@yield('title')</title>
</head>
<body>
  <section class="hero is-primary">
    <div class="hero-head">
      <div class="container">
        <nav class="nav">
          <div class="nav-left">
            <a class="nav-item is-brand" href="{{ route('home') }}">
              Discord Hooker
            </a>
          </div>
          <div class="nav-center">
            <div class="nav-item">
              <span class="icon">
                <i class="fa fa-github"></i>
              </span>
            </div>
          </div>
          <div class="nav-right nav-menu">
            <a href="{{route('home')}}" class="nav-item {{ request()->route()->getName() == 'home' ? 'is-active':'' }}">Home</a>
            <a href="{{route('dispatcher')}}" class="nav-item {{ request()->route()->getName() == 'dispatcher' ? 'is-active':'' }}">Dispatcher</a>
          </div>
        </nav>
      </div>
    </div>
  </section>
  <section class="section">
    <div class="container">
        @yield('content')
    </div>
  </section>
  <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
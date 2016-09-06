@extends('app.layout')
@section('content')
    <div class="container section">
      <div class="columns is-vcentred">
        <div class="column">
          <p class="title">
            Dispatcher
          </p>
          <p class="subtitle">
            Here you can setup your webhooks
          </p>
        </div>
        @if(auth()->check())
          <div class="column is-narrow">
            <div class="box">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-64x64">
                    <img src="{{ auth()->user()->avatar }}">
                  </figure>
                </div>
                <div class="media-content">
                  <p><strong>{{ auth()->user()->name }}</strong></p>
                  <p>
                    <a href="{{route('auth.logout')}}" class="button is-primary">Log out</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
    <vm-dispatcher></vm-dispatcher>
@endsection
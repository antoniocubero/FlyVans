<nav class='padding-sides'>
  <h1><a href="{{route('home')}}">FlyVans</a></h1>
  <ul>
    <li><a href="{{route('home')}}">Inicio</a></li>
    <li><a href="{{route('search')}}">Busqueda</a></li>
    @guest
    <li><button id="open-login">Iniciar sesion</button></li>
    <li><a href="{{route('register')}}">Registrarse</a></li>
    @endguest
    @auth
    <li><a href="{{route('profile')}}">Perfil</a></li>
    <li>
      <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit">
            Cerrar sesión
        </button>
    </form>
    </li>
    @endauth
  </ul>
  @guest
  <div id="login-form" class="form-container shadow-md w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" id="login-form">
    <div id='login-form-head'>
      <h2 class='mb-4'>Iniciar sesion</h2>
      <button id="close-login"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="icon icon-tabler icons-tabler-filled icon-tabler-x" viewBox="0 0 640 640">
        <path d="M183.1 137.4C170.6 124.9 150.3 124.9 137.8 137.4C125.3 149.9 125.3 170.2 137.8 182.7L275.2 320L137.9 457.4C125.4 469.9 125.4 490.2 137.9 502.7C150.4 515.2 170.7 515.2 183.2 502.7L320.5 365.3L457.9 502.6C470.4 515.1 490.7 515.1 503.2 502.6C515.7 490.1 515.7 469.8 503.2 457.3L365.8 320L503.1 182.6C515.6 170.1 515.6 149.8 503.1 137.3C490.6 124.8 470.3 124.8 457.8 137.3L320.5 274.7L183.1 137.4z"/>
      </svg></button>
    </div>
    <form action="{{ route('login') }}" method="post">
      @csrf
      <!-- Email -->
      <div class="mt-4">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
      </div>
      <!-- Contraseña -->
      <div class="mt-4">
          <x-input-label for="password" :value="__('Contraseña')" />
          <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <x-primary-button class="button-main">
            {{ __('Iniciar sesion') }}
        </x-primary-button>
      </div>
    </form>
  </div>
  @endguest

</nav>

@if($errors->any())
  <div class='info-message'>
    <p>{{ $errors->first() }}</p>
    <button id='close-info-message'>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="icon icon-tabler icons-tabler-filled icon-tabler-x" viewBox="0 0 640 640">
        <path d="M183.1 137.4C170.6 124.9 150.3 124.9 137.8 137.4C125.3 149.9 125.3 170.2 137.8 182.7L275.2 320L137.9 457.4C125.4 469.9 125.4 490.2 137.9 502.7C150.4 515.2 170.7 515.2 183.2 502.7L320.5 365.3L457.9 502.6C470.4 515.1 490.7 515.1 503.2 502.6C515.7 490.1 515.7 469.8 503.2 457.3L365.8 320L503.1 182.6C515.6 170.1 515.6 149.8 503.1 137.3C490.6 124.8 470.3 124.8 457.8 137.3L320.5 274.7L183.1 137.4z"/>
      </svg>
    </button>
  </div>
@endif

@vite('resources/js/nav.js')
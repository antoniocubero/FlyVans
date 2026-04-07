<nav class='padding-sides'>
  <h1><a href="{{route('home')}}">FlyVans</a></h1>
  <ul>
    <li><a href="{{route('home')}}">Inicio</a></li>
    <li><a href="{{route('search')}}">Busqueda</a></li>
    @guest
    <li><button x-on:click="showLoginForm = true">Iniciar sesion</button></li>
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
  <div x-show='showLoginForm' class="form-container shadow-md w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" id="login-form">
    <button x-on:click="showLoginForm = false">X</button>
    <form action="{{ route('login') }}" method="post">
      @csrf
      <h2 class='mb-4'>Iniciar sesion</h2>

      <!-- Email -->
      <div class="mt-4">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>
      <!-- Contraseña -->
      <div class="mt-4">
          <x-input-label for="password" :value="__('Contraseña')" />

          <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

          <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
            {{ __('¿Olvidaste tu contraseña?') }}
        </a>
        <x-primary-button class="ms-4">
            {{ __('Iniciar sesion') }}
        </x-primary-button>
      </div>
    </form>
  </div>
  @endguest
</nav>



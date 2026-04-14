@include('head')
@include('nav')


<section id='anuncio-section' class='padding-sides'>
  <div id='anuncio-container'>
    <h1>{{$anuncio->caravana->marca}} {{$anuncio->caravana->modelo}}</h1>
    <div id='anuncio-images'>
      <img id='main-image' src="{{$anuncio->caravana->foto_principal_url}}" alt="Foto principal">
      <div id='mini-images'>
        @foreach($anuncio->caravana->fotos as $foto)
          <img src="{{$foto->url}}" alt="Foto adicional">
        @endforeach
      </div>
    </div>

    <div id='anuncio-description'>
      <h2>{{$anuncio->titulo}}
      @if(optional($anuncio->caravana)->nota)
        - {{$anuncio->caravana->nota}} <span class='star'>★</span>
      @endif
      </h2>
      <div class='div-2'>
        <p>Precio dia: <strong>{{$anuncio->precio_dia}}€</strong></p>
        <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#6750A4" class="icon icon-tabler icons-tabler-filled icon-tabler-map-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6" /></svg>{{$anuncio->localizacion}}</p>
      </div>
      <p class='descripcion'>{{$anuncio->descripcion}}</p>
      <p class='info-van'>Marca: {{$anuncio->caravana->marca}}</p>
      <p class='info-van'>Modelo: {{$anuncio->caravana->modelo}}</p>
      <p class='info-van'>Kilometros: {{$anuncio->caravana->kilometraje}}km</p>
    </div>

    @if($anuncio->valoraciones->count() > 0)
    <div class="valoraciones">
      <h3>Reseñas</h3>
        @foreach($valoraciones as $valoracion)
            <div class="card-valoracion">
                <p><strong>{{ $valoracion->reserva->user->name ?? 'Usuario' }}</strong> - {{ $valoracion->puntuacion }} ★ - {{ $valoracion->fecha }}</p>
                <p>{{ $valoracion->comentario }}</p>
            </div>
        @endforeach
    </div>
    @endif

  </div>

  <div id='anuncio-reserva'>
    @auth
      @if($anuncio->caravana->id_usuario_propietario != auth()->id())
        <div>
          <form action="{{route('booking.store')}}" method='POST'>
            @csrf
            <div>
              <x-input-label for="_fechas" :value="__('Fechas disponibles')" />
    
              <x-text-input class="block mt-1 w-full" type="text" name='_fechas' id="rango_fechas" placeholder="Selecciona fechas" required/>
    
              <x-input-error :messages="$errors->get('fechas')" class="mt-2" />
              <x-input-error :messages="$errors->get('reserva')" class="mt-2" />
              <x-input-error :messages="$errors->get('id_anuncio')" class="mt-2" />
              <input type="hidden" name="fechas" id="fechas_hidden">
              <input type="hidden" name="id_anuncio" value="{{ $anuncio->id }}">
            </div>
            <div>
              <p>Días: <strong id="total-days">0</strong></p>
              <p>Total: <strong id='price-total'>0</strong>€</p>
            </div>
            <button class='button-main' type="submit">Reservar</button>
          </form>
        </div>
      @else
        <div class="owner-message">
          <h2>¡Este anuncio es tuyo!</h2><br>
          <a class='button-main' href="{{route('ads.edit', $anuncio->id)}}">Editar anuncio</a>
        </div>
      @endif
    @endauth
    @guest
    <div>
      <div>
        <x-input-label for="_fechas" :value="__('Fechas disponibles')" />

        <x-text-input class="block mt-1 w-full" type="text" name='_fechas' id="rango_fechas" placeholder="Selecciona fechas" required/>

        <x-input-error :messages="$errors->get('fechas')" class="mt-2" />
      </div>

      <p>Inicia sesión para poder hacer la reserva</p>
      <button id='open-login-ad' class='button-main' type="button">Iniciar sesion</button>
    </div>
    @endguest
  </div>


</section>


@include('footer')

@if(session('success'))
<script>
  window.successMessage = "{{ session('success') }}";
</script>
@endif
<script>
  window.fechasOcupadas = @json($fechasOcupadas);
  window.precioDia = {{ $anuncio->precio_dia }};
</script>
@vite('resources/js/ad.js')
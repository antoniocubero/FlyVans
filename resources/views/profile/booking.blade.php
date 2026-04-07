@include('head')
@include('nav')

<section id='booking-section'>
<!-- <p>Propietario: {{ $propietario ? 'Sí' : 'No' }}</p> -->

  <div class='booking-details'>
    <h2>Reserva <!-- {{$reserva->id}} --></h2>

    <p>
      {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}
      -
      {{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}
      ({{ \Carbon\Carbon::parse($reserva->fecha_inicio)->diffInDays($reserva->fecha_fin) }} días)
    </p>

    <div>
      <p>Estado:
      @if($reserva->estado == 'cancelada')
        <span style="color:red;">Cancelada</span>
      </p>
      @elseif($reserva->estado == 'pendiente')
        <span style="color:orange;">Pendiente</span></p>
        <div id='buttons-container'>
          @if($puedeAceptar)
            <form action="/profile/booking/{{$reserva->id}}/accept" method="POST">
              @csrf
              <button class='button-ter' type="submit">Aceptar reserva</button>
            </form>
          @endif
  
          @if($puedeCancelar || $puedeAceptar)
            <form action="/profile/booking/{{$reserva->id}}/cancel" method="POST">
              @csrf
              <button class='button-sec' type="submit">
                {{ $propietario ? 'Denegar' : 'Cancelar reserva' }}
              </button>
            </form>
          @endif
  
          @if($puedeValorar)
            <a href="/rating/{{$reserva->id}}/new">Valorar</a>
          @endif
        </div>
      
      @else
        <span style="color:green;">Aceptada</span></p>
      @endif
    </div>
  </div>
    <hr>

  <div class='card-van'>
    <h2>Caravana</h2>
    <img src="{{$reserva->anuncio->caravana->foto_principal_url}}" alt="" srcset="">
    <p>
      {{ $reserva->anuncio->caravana->marca }}
      {{ $reserva->anuncio->caravana->modelo }}
    </p>
    <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#6750A4" class="icon icon-tabler icons-tabler-filled icon-tabler-map-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6" /></svg> {{ $reserva->anuncio->localizacion }}</p>

    @if($reserva->anuncio->caravana->nota)
      <p><span class='star'>★</span> {{ $reserva->anuncio->caravana->nota }}</p>
    @endif

    <p>Precio por día: {{ number_format($reserva->anuncio->precio_dia, 2) }} €</p>

    <p><strong>Total: {{ number_format($reserva->coste, 2) }} €</strong></p>
  </div>
  <hr>
  @if($reserva->valoracion)
  <div class='card-review'>
      <h2>Valoracion - {{$reserva->valoracion->puntuacion}}<span class='star'>★</span></h2>
      <p><strong>{{$reserva->valoracion->fecha}}</strong></p>
      <p>{{$reserva->valoracion->comentario}}</p>
  </div>
  @endif

</section>


@include('footer')
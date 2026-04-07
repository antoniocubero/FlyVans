@include('head')
@include('nav')

<section id='rating-section' class='padding-sides'>
  <a href="/profile">Volver</a>

  <h1>Valorar reserva</h1>

  <h3>
    Reserva {{ $reserva->fecha_inicio->format('d/m/Y') }} - 
    {{ $reserva->fecha_fin->format('d/m/Y') }}
  </h3>

  <form action="{{ route('rating.store', $reserva->id) }}" method="POST">
    @csrf

  <div>
    <x-input-label for="puntuacion" :value="__('Puntuación')" />
    <div class="stars">
      @for ($i = 5; $i >= 1; $i--)
        <input 
          type="radio" 
          id="star{{ $i }}" 
          name="puntuacion" 
          value="{{ $i }}"
          {{ old('puntuacion') == $i ? 'checked' : '' }}
        >
        <label for="star{{ $i }}">★</label>
      @endfor
    </div>
    <x-input-error :messages="$errors->get('puntuacion')" class="mt-2" />
    
  </div>
    <div>
      <x-input-label for="comentario" :value="__('Comentario')" />
      <textarea 
        id="comentario"
        name="comentario"
        class="block mt-1 w-full"
        rows="4"
      >{{ old('comentario') }}</textarea>
      <x-input-error :messages="$errors->get('comentario')" class="mt-2" />
    </div>

    <button type="submit">Enviar valoración</button>
  </form>
</section>
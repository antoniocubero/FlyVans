<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  @include('head')
  @include('nav')
  <section class='padding-sides' id='main-banner'>
    <div id='banner-image-container'>
      <img src="{{ asset('images/banner-main.webp') }}" alt="">
    </div>
    <div>
      <h1>Elije tu viaje, <br> Elije Flyvans</h1>
      <h2>Alquiler de caravanas en España</h2>
    </div>


  </section>



  <section class='padding-sides' id='main-places'>
    <h1>Descubre nuevos lugares</h1>
    <h2>Con FlyVans todo es posible</h2>
    <div id='cards-places'>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/lagos-covadonga.webp') }}" alt="Lagos de Covadonga">
        </div>
        <h3>Lagos de Covadonga</h3>
        <h4>Asturias</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/playa-de-piles.webp') }}" alt="Playa de Piles">
        </div>
        <h3>Playa de Piles</h3>
        <h4>Valencia</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/torcal-antequera.webp') }}" alt="Torcal de Antequera">
        </div>
        <h3>Torcal de Antequera</h3>
        <h4>Malaga</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/donana.webp') }}" alt="Doñana">
        </div>
        <h3>Doñana</h3>
        <h4>Huelva</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/sierra-guadarrama.webp') }}" alt="Sierra de Guadarrama">
        </div>
        <h3>Sierra de Guadarrama</h3>
        <h4>Madrid</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/playa-de-benijo.webp') }}" alt="Playa de Benijo">
        </div>
        <h3>Playa de Benijo</h3>
        <h4>Tenerife</h4>
      </div>
    </div>
  </section>

  @include('footer')
  
</body>
</html>
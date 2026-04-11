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

    <div id='main-search-form'>
      <form action="" method="get">
        @csrf
        <select name="location" id="location-select">
          <option value="0">Elije un destino</option>
        </select>
        <input type="date" name="" id="">
        <button type="submit">Buscar</button>
      </form>
    </div>

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
          <img src="{{ asset('images/lagos-covadonga.webp') }}" alt="Lagos de Covadonga">
        </div>
        <h3>Lagos de Covadonga</h3>
        <h4>Asturias</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/lagos-covadonga.webp') }}" alt="Lagos de Covadonga">
        </div>
        <h3>Lagos de Covadonga</h3>
        <h4>Asturias</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/lagos-covadonga.webp') }}" alt="Lagos de Covadonga">
        </div>
        <h3>Lagos de Covadonga</h3>
        <h4>Asturias</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/lagos-covadonga.webp') }}" alt="Lagos de Covadonga">
        </div>
        <h3>Lagos de Covadonga</h3>
        <h4>Asturias</h4>
      </div>
      <div class='card-place'>
        <div class='card-place-image'>
          <img src="{{ asset('images/lagos-covadonga.webp') }}" alt="Lagos de Covadonga">
        </div>
        <h3>Lagos de Covadonga</h3>
        <h4>Asturias</h4>
      </div>
    </div>
  </section>

  @include('footer')
  
</body>
</html>
@include('head')
@include('nav')

<section id='search-section'>
  <div id="search-filters">
    <form action="" method="get">
      <h3>Marcas</h3>
      <div id="brands-container">

      </div>
      <button id="load-more-brands"  type="button">Cargar más</button>

      <h3>Ordernar por:</h3>
      <select name="orden" id="">
        <option value="">-- Seleccionar --</option>
        <option value="nota-asc">Nota (ascendente)</option>
        <option value="nota-desc">Nota (descendente)</option>
        <option value="precio-asc">Precio (ascendente)</option>
        <option value="precio-desc">Precio (descendente)</option>
      </select>

      <h3>Localizacion</h3>
      <div id="locations-container">
          
      </div>
      <button id="load-more-locations"  type="button">Cargar más</button>

      <div class='buttons-container'>
        <button class='button-ter' type="submit">Aplicar filtros</button>
        <button class='button-sec' type="button" id="reset-filters">Reiniciar</button>
      </div>
      
    </form>
  </div>
  <div id='search-results-container'>
    <div id='search-results' data-last-page="{{ $anuncios->lastPage() }}">

    </div>
    <div id="limit"></div>
  </div>
</section>



@include('footer')
@vite('resources/js/search.js')

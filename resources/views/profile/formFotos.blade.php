@include('head')
@include('nav')

<section id='fotos-section' class="padding-sides">

  <h1>Añadir fotos</h1>

  <form action="{{ route('photos.store', $caravana->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
    <div>
      <x-input-label for="fotos" :value="__('Añadir fotos')" />
      <input type="file" name="fotos[]" multiple accept="image/*">
    </div>

    <div class="button-container">
      <button class='button-ter' type="submit">Subir fotos</button>
      <a href="/profile" class="button-sec">Omitir</a>
    </div>
  </form>

</section>

@include('footer')
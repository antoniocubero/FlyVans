@include('head')
@include('nav')

<section id='edit-van-section' class='padding-sides'>
  @if(session('success'))
      <div class="success-message">
          {{ session('success') }}
      </div>
  @endif
  <div id='edit-head'>
    <h1>Editar caravana</h1>
    <a class='button-main' href="/profile">Volver</a>
  </div>
  <form action="{{ route('editVan', $caravana->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div>
      <x-input-label for="marca" :value="__('Marca')" />
      <x-text-input id="marca" class="block mt-1 w-full" type="text" name="marca" :value="$caravana->marca" required autofocus autocomplete="marca" />
      <x-input-error :messages="$errors->get('marca')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="modelo" :value="__('Modelo')" />
      <x-text-input id="modelo" class="block mt-1 w-full" type="text" name="modelo" :value="$caravana->modelo" required autofocus autocomplete="modelo" />
      <x-input-error :messages="$errors->get('modelo')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="kilometros" :value="__('Kilometros')" />
      <x-text-input id="kilometros" class="block mt-1 w-full" type="number" name="kilometros" :value="$caravana->kilometraje" required autofocus autocomplete="kilometros" />
      <x-input-error :messages="$errors->get('kilometros')" class="mt-2" />
    </div>
    
    <button class='button-ter' type="submit">Guardar cambios</button>
  </form>
  <hr>
  <div id='fotos'>
    <h3>Fotos</h3>
    <div id='fotos-van'>
      @foreach($fotos as $foto)
        <div class="foto-item">
          <div class="img-wrapper {{ $foto->es_principal ? 'principal' : '' }}">
            <img src="{{$foto->url}}">
          </div>
          <div class="foto-actions">
            <form action="{{ route('fotos.destroy', $foto->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button class='button-main' type="submit">Eliminar</button>
            </form>

            @if(!$foto->es_principal)
            <form action="{{ route('fotos.principal', $foto->id) }}" method="POST">
              @csrf
              <button class='button-main' type="submit">Hacer principal</button>
            </form>
            @endif
          </div>
          
        </div>
      @endforeach
    </div>
    <div id='fotos-add'>
      <form action="{{ route('fotos.store', $caravana->id) }}" method='post' enctype="multipart/form-data">
        @csrf
        <x-input-label for="fotos" :value="__('Añadir fotos')" />
        <input type="file" name="fotos[]" multiple accept="image/*">
        <x-input-error :messages="$errors->get('fotos')" class="mt-2" />
        <input type="hidden" name="back" value="1">
        <button class='button-ter' type='submit'>Guardar imagenes</button>
      </form>
    </div>
  </div>
</section>
@include('footer')
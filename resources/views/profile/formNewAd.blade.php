@include('head')
@include('nav')

<section id='new-van-section' class='padding-sides'>
  <div id='edit-head'>
    <a href="/profile" class='button-main'>Volver</a>
    <h1>Crear anuncio</h1>
  </div>
  <form action="{{ route('ads.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div>
      <x-input-label for="titulo" :value="__('Titulo')" />
      <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" required autofocus autocomplete="titulo" />
      <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="descripcion" :value="__('Descripcion')" />
      <textarea rows=4 class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="descripcion" required autofocus autocomplete="descripcion">{{old('descripcion')}}</textarea>
      <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="precio_dia" :value="__('Precio por dia')" />
      <x-text-input id="precio_dia" class="block mt-1 w-full" type="number" name="precio_dia" step="0.01" :value="old('precio_dia')" required autofocus autocomplete="precio_dia" />
      <x-input-error :messages="$errors->get('precio_dia')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="localizacion" :value="__('Localizacion')" />
      <x-text-input id="localizacion" class="block mt-1 w-full" type="text" name="localizacion" :value="old('localizacion')" required autofocus autocomplete="localizacion" />
      <x-input-error :messages="$errors->get('localizacion')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="id_caravana" :value="__('Caravana elegida')" />
      <select name="id_caravana">
        @foreach($caravanas as $caravana)
          <option value="{{$caravana->id}}">{{$caravana->marca}} {{$caravana->modelo}}</option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('id_caravana')" class="mt-2" />
    </div>
    
    <button class='button-ter' type="submit">Crear</button>
  </form>
</section>

@include('footer')
@include('head')
@include('nav')

<section id='new-van-section' class='padding-sides'>
  <div id='edit-head'>
    <a href="/profile" class='button-main'>Volver</a>
    <h1>Crear Caravana</h1>
  </div>
  <form action="{{ route('vans.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div>
      <x-input-label for="marca" :value="__('Marca')" />
      <x-text-input id="marca" class="block mt-1 w-full" type="text" name="marca" :value="old('marca')" required autofocus autocomplete="marca" />
      <x-input-error :messages="$errors->get('marca')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="modelo" :value="__('Modelo')" />
      <x-text-input id="modelo" class="block mt-1 w-full" type="text" name="modelo" :value="old('modelo')" required autofocus autocomplete="modelo" />
      <x-input-error :messages="$errors->get('modelo')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="matricula" :value="__('Matricula (Formato: 0000XXX)')" />
      <x-text-input id="matricula" class="block mt-1 w-full" type="text" name="matricula" :value="old('matricula')" required autofocus autocomplete="matricula" />
      <x-input-error :messages="$errors->get('matricula')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="kilometros" :value="__('Kilometros')" />
      <x-text-input id="kilometros" class="block mt-1 w-full" type="number" name="kilometros" :value="old('kilometros')" required autofocus autocomplete="kilometros" />
      <x-input-error :messages="$errors->get('kilometros')" class="mt-2" />
    </div>
    
    <button class='button-ter' type="submit">Crear</button>
  </form>
</section>
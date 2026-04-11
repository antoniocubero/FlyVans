@include('head')
@include('nav')


<section id='profile-section' class=''>
  <h2 class='padding-sides'>Panel de usuario</h2>
  <div id='profile-header' class='padding-sides'>
    <div>
      <h1>Hola {{ $nombre }}</h1>
      <h3>¿Que vamos a hacer hoy?</h3>
      <a class='button-main' href='/profile/edit'>Editar perfil</a>
    </div>
    <div id='profile-buttons'>
      <button id='btn-caravanas' class='selected'>Caravanas</button>
      <button id='btn-anuncios'>Anuncios</button>
      <button id='btn-reservas'>Reservas</button>
    </div>
  </div>
  <div id='profile-content' class='padding-sides'>
    <div id='profile-content-head'>
      <h1>Cargando...</h1>
    </div>
    <div id='container'>
      
    </div>
  </div>
</section>



@if(session('success'))
<script>
  window.successMessage = "{{ session('success') }}";
</script>
@endif
@include('footer')
@vite('resources/js/profile.js')
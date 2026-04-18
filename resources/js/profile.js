import { mostrarMensaje } from './utils/notifications.js';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', () =>{
  switch (localStorage.getItem('profileTab')) {
    case 'anuncios':
      cargarAnuncios()
      break;
    
    case 'reservas': 
      cargarReservasArrendatario()
      break;
      
    default:
      cargarCaravanas()
      break;
  }

  if (window.successMessage) {
    mostrarMensaje(window.successMessage, 'success');
  }

  const btnCaravanas = document.querySelector('#btn-caravanas')
  btnCaravanas.addEventListener('click', cargarCaravanas)
  const btnReservas = document.querySelector('#btn-reservas')
  btnReservas.addEventListener('click', cargarReservasArrendatario)
  const btnAnuncios = document.querySelector('#btn-anuncios')
  btnAnuncios.addEventListener('click', cargarAnuncios)

/*   const buttonsHeader = document.querySelectorAll('#profile-buttons button')
  buttonsHeader.forEach(btn => btn.addEventListener('click', selectButton)) */

  document.addEventListener('click', (e) => {
    // ELIMINAR CARAVANA
    if (e.target.classList.contains('btn-eliminar-van')) {
      const id = e.target.dataset.id;
      const btn = e.target;

      mostrarConfirmacion('¿Seguro que quieres eliminar esta caravana?',
        () => eliminarCaravana(id, btn)
      );
    }

    // ELIMINAR ANUNCIO
    if (e.target.classList.contains('btn-eliminar-anuncio')) {
      const id = e.target.dataset.id;
      const btn = e.target;

      mostrarConfirmacion('¿Seguro que quieres eliminar este anuncio? Se cancelaran todas las reservas pendientes, las reservas confirmadas se mantendran',
        () => eliminarAnuncio(id, btn)
      );
    }

    //CANCELAR RESERVA
    if(e.target.classList.contains('btn-cancelar-reserva-o')){
      const id = e.target.dataset.id;

      console.log(id);

      mostrarConfirmacion('¿Seguro que quieres cancelar la reserva?', 
        () => cancelarReserva(id, true), true
      )
    }

    if(e.target.classList.contains('btn-cancelar-reserva-r')){
      const id = e.target.dataset.id;

      console.log(id);

      mostrarConfirmacion('¿Seguro que quieres cancelar la reserva?', 
        () => cancelarReserva(id), true
      )
    }



    //ACEPTAR RESERVA
    if(e.target.classList.contains('btn-aceptar-reserva')){
      const id = e.target.dataset.id;

      console.log(id);

      mostrarConfirmacion('¿Seguro que quieres aceptar la reserva?, Se cancelaran todas las reservas pendientes cuyas fechas coincidan', 
        () => aceptarReserva(id)
      )
    }

  });

})


async function test(){
  console.log('test')
  const response = await fetch('/api/vans', {
    headers: { 'Accept': 'application/json' },
    credentials: 'include'
  });
  const data = await response.json();
  console.log(data)
}


async function cargarCaravanas(){
  tabSelected('caravanas')
  const contenedor = vaciarContenedor()
  try{
    const response = await fetch('/api/profile/vans', {
      headers: { 'Accept': 'application/json' },
      credentials: 'include'
    });
  
    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }

  
    const data = await response.json();

    console.log(data)
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = data.title;

    titulo.insertAdjacentHTML('afterend', `
        <a class='button-ter' href='/profile/van/new'>+ Nueva Caravana</a>
      `)

    for (const caravana of data.vans){
      contenedor.insertAdjacentHTML('beforeend', `
        <div class='card'>
          <div class='card-left'>
            <h3>${caravana.marca}</h3>
            <h4>${caravana.modelo}</h4>
          </div>
          <div class='card-right'>
            <a href="/profile/van/${caravana.id}/edit">Editar</a>|
            <button class="btn-eliminar-van" data-id="${caravana.id}">Eliminar</button>
            <img src="${caravana.foto_principal}" alt="">
          </div>
        </div>
        `)
    }
  }catch(error){
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = 'Ha ocurrido un error';
    mostrarMensaje('Error al cargar las caravanas, intentelo de nuevo', 'error');
  }
}


async function cargarAnuncios(){
  tabSelected('anuncios')
  const contenedor = vaciarContenedor()
  
  try{
    const response = await fetch('/api/profile/ads', {
      headers: { 'Accept': 'application/json' },
      credentials: 'include'
    });
  
    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }

    const data = await response.json();

    console.log(data)
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = data.title;

    titulo.insertAdjacentHTML('afterend', `
        <a class='button-ter' href='/profile/ad/new'>+ Crear Anuncio</a>
      `)


    for (const anuncio of data.ads){
      contenedor.insertAdjacentHTML('beforeend', `
        <div class='card'>
          <div class='card-left'>
            <h3> ${anuncio.titulo}</h3>
            <h4>${anuncio.caravana} - ${anuncio.precio_dia}€</h4>
          </div>
          <div class='card-right'>
            <a href="/profile/ad/${anuncio.id}/edit">Editar</a>|
            <button class='btn-eliminar-anuncio' data-id="${anuncio.id}">Eliminar</button>
            <img src="${anuncio.foto_principal}" alt="">
          </div>
        </div>
        `)
    }
  }catch(error){
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = 'Ha ocurrido un error';
    mostrarMensaje('Error al cargar los anuncios, intentelo de nuevo', 'error');
  }
}


async function cargarReservasArrendatario(){
  tabSelected('reservas')
  const contenedor = vaciarContenedor()
  
  try{
    const response = await fetch('/api/profile/bookings-o', {
      headers: { 'Accept': 'application/json' },
      credentials: 'include'
    });
  
    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }
  
    const data = await response.json();

    console.log(data)
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = data.title;

    titulo.insertAdjacentHTML('afterend', `
        <button class='selected' id='btn-reservas-arrendatario'>Arrendatario</button>
        <button id='btn-reservas-arrendador'>Arrendador</button>
      `)

    document.querySelector('#btn-reservas-arrendatario').addEventListener('click', cargarReservasArrendatario)
    document.querySelector('#btn-reservas-arrendador').addEventListener('click', cargarReservasArrendador)


    const hoy = new Date();
    for (const reserva of data.bookings){
      const [dia, mes, año] = reserva.fecha_fin.split('/');
      const fechaFin = new Date(`${año}-${mes}-${dia}`);

      const puedeValorar = (reserva.estado === 'Confirmada' && hoy > fechaFin && reserva.valoracion_id_reserva === null);

      contenedor.insertAdjacentHTML('beforeend', `
        <div class='card ${(reserva.estado != 'Pendiente') ? 'inactiva':''}'>
          <div class='card-left'>
            <h3>Reserva ${reserva.fecha_inicio} - ${reserva.fecha_fin} | ${reserva.estado}</h3>
            <h4>${reserva.caravana} - ${reserva.coste}€ ${reserva.valoracion_puntuacion !== null ? ` - Valoracion: ${reserva.valoracion_puntuacion} <span class='star'>★</span>`:''}</h4>
          </div>
          <div class='card-right'>
            ${puedeValorar ? `<a href="/rating/${reserva.id}/new">Valorar</a> |` : ''}
            <a href="/profile/booking/${reserva.id}">Abrir</a>
            ${(reserva.estado == 'Pendiente') ? `|<button class='btn-cancelar-reserva-o' data-id="${reserva.id}">Cancelar</button>`:''}
            
            <img src="${reserva.foto_principal}" alt="">
          </div>
        </div>
        `)
    }
  }catch(error){
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = 'Ha ocurrido un error';
    mostrarMensaje('Error al cargar las reservas, intentelo de nuevo', 'error');
  }
}

async function cargarReservasArrendador(){
  tabSelected('reservas')
  const contenedor = vaciarContenedor()
  
  try{
    const response = await fetch('/api/profile/bookings-r', {
      headers: { 'Accept': 'application/json' },
      credentials: 'include'
    });
  
    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }
  
    const data = await response.json();

    console.log(data)
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = data.title;

    titulo.insertAdjacentHTML('afterend', `
        <button id='btn-reservas-arrendatario'>Arrendatario</button>
        <button class='selected' id='btn-reservas-arrendador'>Arrendador</button>
      `)

    document.querySelector('#btn-reservas-arrendatario').addEventListener('click', cargarReservasArrendatario)
    document.querySelector('#btn-reservas-arrendador').addEventListener('click', cargarReservasArrendador)

    for (const reserva of data.bookings){
      contenedor.insertAdjacentHTML('beforeend', `
        <div class='card ${(reserva.estado != 'Pendiente') ? 'inactiva':''}'>
          <div class='card-left'>
            <h3>Reserva ${reserva.fecha_inicio} - ${reserva.fecha_fin} | ${reserva.estado}</h3>
            <h4>${reserva.caravana} - ${reserva.coste}€</h4>
          </div>
          <div class='card-right'>
            <a href="/profile/booking/${reserva.id}">Abrir</a>
            ${(reserva.estado == 'Pendiente') ? `|<button class='btn-aceptar-reserva' data-id="${reserva.id}">Aceptar</button>|<button class='btn-cancelar-reserva-r' data-id="${reserva.id}">Denegar</button>`:''}
            
            <img src="${reserva.foto_principal}" alt="">
          </div>
        </div>
        `)
    }
  }catch(error){
    const titulo = document.querySelector('#profile-content > div > h1')
    titulo.textContent = 'Ha ocurrido un error';
    mostrarMensaje('Error al cargar las reservas, intentelo de nuevo', 'error');
  }
}


//ELIMINAR

async function eliminarCaravana(id, boton){
  try{
    const formData = new FormData();
    formData.append('_method', 'DELETE');

    const response = await fetch(`/profile/van/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: formData
    });

    if(!response.ok){
      throw new Error(`Error HTTP: ${response.statusText}`);
    }

    mostrarMensaje('Caravana eliminada', 'success');
    boton.closest('.card').remove();

  }catch(error){
    mostrarMensaje('Error al eliminar la caravana, intentelo de nuevo', 'error');
  }
}

async function eliminarAnuncio(id, boton) {
  try {
    const formData = new FormData();
    formData.append('_method', 'DELETE');

    const response = await fetch(`/profile/ad/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: formData
    });

    if (!response.ok){
      throw new Error(`Error HTTP: ${response.statusText}`);
    } 

    mostrarMensaje('Anuncio eliminado', 'success');
    boton.closest('.card').remove();

  } catch (error) {
    mostrarMensaje('Error al eliminar el anuncio, intentelo de nuevo', 'error');
  }
}

async function cancelarReserva(id, arrendatario){
  try {
    const response = await fetch(`/profile/booking/${id}/cancel`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    })

    if (!response.ok){
      throw new Error(`Error HTTP: ${response.statusText}`);
    }

    mostrarMensaje('Reserva cancelada', 'success');

    if(arrendatario){
      cargarReservasArrendatario();
    }else{
      cargarReservasArrendador();
    }

  } catch (error) {
    mostrarMensaje('Error al cancelar la reserva, intentelo de nuevo', 'error');
  }
}


//ACEPTAR RESERVA
async function aceptarReserva(id){
  try {
    const response = await fetch(`/profile/booking/${id}/accept`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    })

    if (!response.ok){
      throw new Error(`Error HTTP: ${response.statusText}`);
    }

    mostrarMensaje('Reserva aceptada', 'success');

    cargarReservasArrendador();
  } catch (error) {
    mostrarMensaje('Error al aceptar la reserva, intentelo de nuevo', 'error');
  }
}


// FUNCIONES AUXILIARES

function mostrarConfirmacion(mensaje, onConfirm, reservas = false) {
  if (document.querySelector('.profile-confirm')) return;

  document.querySelector('#profile-header').insertAdjacentHTML('beforeend', `
    <div class='profile-confirm'>
      <div class='confirm-box'>
        <span>${mensaje}</span>
        <div>
          <button class='button-sec' id="confirmar-btn">${(reservas ? 'Cancelar reserva':'Confirmar')}</button>
          <button class='button-ter' id="cancelar-btn">${(reservas ? 'salir':'Cancelar')}</button>
        </div>
      </div>
    </div>
  `);

  document.querySelector('#confirmar-btn').addEventListener('click', () => {
    onConfirm();
    cerrarConfirmacion();
  });

  document.querySelector('#cancelar-btn').addEventListener('click', cerrarConfirmacion);
}

function cerrarConfirmacion() {
  document.querySelector('.profile-confirm')?.remove();
}

function tabSelected(valor){
  localStorage.setItem('profileTab', valor)
  const buttons = document.querySelectorAll('#profile-buttons button')
  buttons.forEach(btn => btn.classList.remove('selected'))
  document.querySelector('#btn-'+valor).classList.add('selected')
}

function clearLocalStorage(){
  localStorage.removeItem('profileTab')
}

function vaciarContenedor(){
  document.querySelector('#profile-content > div > h1').textContent = 'Cargando...';

  const contenedor = document.querySelector('#profile-content>#container')
  const enlaceNuevo = document.querySelector('#profile-content-head > a')
  const btns = document.querySelectorAll('#profile-content-head > button')

  if(enlaceNuevo !== null){
    enlaceNuevo.remove();
  }

  if (btns !== null) {
    btns.forEach((btn)=>btn.remove())
  }
  
  //console.log(enlaceNuevo);


  contenedor.innerHTML = '';
  return contenedor;
}
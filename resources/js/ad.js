import { mostrarMensaje } from './utils/notifications.js';

document.addEventListener('DOMContentLoaded', () =>{
  const openBtn = document.getElementById('open-login-ad');
  const modal = document.getElementById('login-form');

  if(openBtn){
    openBtn.addEventListener('click', () => {
      modal.style.display = 'block';
    });
  }

  if (window.successMessage) {
    mostrarMensaje(window.successMessage, 'success');
  }


  const miniImages = document.querySelectorAll('#mini-images img')

  miniImages.forEach(img => {
    img.addEventListener('click', changeImage)
  })

  const fechasOcupadas = window.fechasOcupadas
  //console.log(fechasOcupadas);

  flatpickr("#rango_fechas", {
    mode: "range",
    dateFormat: "d-m-Y",
    minDate: "today",

    disable: [
      function(date) {
        const d = date.toLocaleDateString('en-CA');
        return window.fechasOcupadas.includes(d);
      }
    ],

    locale: flatpickr.l10ns.es, //traduce a español

    showMonths: 1, 
    onChange: function(selectedDates) {
      if (selectedDates.length === 2) {
        const start = selectedDates[0]
        const end = selectedDates[1]

        const startFormatted = start.toLocaleDateString('en-CA')
        const endFormatted = end.toLocaleDateString('en-CA')

        const fechasHidden = document.querySelector('#fechas_hidden')
        if (fechasHidden) {
          fechasHidden.value = startFormatted + '|' + endFormatted
        }
        

        const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1

        const total = Math.round(diffDays * window.precioDia * 100) / 100

        document.querySelector('#price-total').textContent = total
        document.querySelector('#total-days').textContent = diffDays
      }


      if (selectedDates.length < 2) {
        document.querySelector('#price-total').textContent = 0
        document.querySelector('#total-days').textContent = 0
        document.querySelector('#fechas_hidden').value = ''
      }
    }

  })
})


function changeImage(){
  const  mainImage = document.querySelector('#main-image')
  mainImage.src = this.src
}
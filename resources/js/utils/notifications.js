export function mostrarMensaje(mensaje, tipo = 'error') {
  const existente = document.querySelector('.info-message');
  if (existente) existente.remove();

  const div = document.createElement('div');
  div.classList.add('info-message');

  if (tipo === 'success') {
    div.classList.add('success');
  } else if (tipo === 'error') {
    div.classList.add('error');
  }

  div.innerHTML = `
    <p>${mensaje}</p>
    <button class="close-info">
      ✕
    </button>
  `;

  document.body.appendChild(div);

  // cerrar
  div.querySelector('.close-info').addEventListener('click', () => {
    div.remove();
  });

  // auto cerrar
  setTimeout(() => {
    div.classList.add('hide');

    setTimeout(() => {
      div.remove();
    }, 500);
  }, 4000);
}
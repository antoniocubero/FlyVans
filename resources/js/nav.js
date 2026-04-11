document.addEventListener('DOMContentLoaded', function () {
  const openBtn = document.getElementById('open-login');
  const closeBtn = document.getElementById('close-login');
  const modal = document.getElementById('login-form');

  openBtn.addEventListener('click', () => {
    modal.style.display = 'block';
  });

  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });


  const closeInfoBtn = document.getElementById('close-info-message');

  if (closeInfoBtn) {
    closeInfoBtn.addEventListener('click', () => {
      const infoBox = document.querySelector('.info-message');
      if (infoBox) {
        infoBox.remove();
      }
    });
  }

  const infoBox = document.querySelector('.info-message');

  if (infoBox) {
    setTimeout(() => {
      infoBox.classList.add('hide');
      setTimeout(() => {
        infoBox.remove();
      }, 500);
      
    }, 4000);
  }
});
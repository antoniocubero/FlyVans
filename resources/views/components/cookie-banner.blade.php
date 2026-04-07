<div id="cookie-banner" class="fixed bottom-0 left-0 w-full bg-gray-900 text-white p-4 flex justify-center items-center" style="display:none; z-index:1000;">
    <span>
        Usamos cookies para mejorar la experiencia. 
        <a href="/politica-cookies" class="underline">Más información</a>
    </span>

    <button onclick="acceptCookies()" class="bg-green-500 px-4 py-2 rounded ml-4">
      Aceptar
    </button>
    <button onclick="rejectCookies()" class="bg-red-500 px-4 py-2 rounded ml-2">
      Rechazar
    </button>
</div>

<script>
function acceptCookies(){
    localStorage.setItem('cookies_accepted', 'true');
    document.getElementById('cookie-banner').style.display = 'none';
}

function rejectCookies(){
    localStorage.setItem('cookies_accepted', 'false');
    document.getElementById('cookie-banner').style.display = 'none';
}

window.onload = function(){
    if(!localStorage.getItem('cookies_accepted')){
        document.getElementById('cookie-banner').style.display = 'flex';
    }
}
</script>
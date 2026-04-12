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
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i=0;i < ca.length;i++) {
        let c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function acceptCookies(){
    setCookie('cookies_accepted', 'true', 365);
    document.getElementById('cookie-banner').style.display = 'none';
}

function rejectCookies(){
    setCookie('cookies_accepted', 'false', 365);
    document.getElementById('cookie-banner').style.display = 'none';
}

window.onload = function(){
    if(!getCookie('cookies_accepted')){
        document.getElementById('cookie-banner').style.display = 'flex';
    }
}
</script>
import { searchInfiniteScroll } from './infinite-scroll';

document.addEventListener('DOMContentLoaded', () => {

    const container = document.querySelector('#search-results');
    const form = document.querySelector('#search-filters form');
    const resetBtn = document.querySelector('#reset-filters');

    if (!container || !form) return;

    let filtros = '';


    primerLoad();
    cargarMarcas();
    cargarLocalizaciones();


    form.addEventListener('submit', aplicarFiltros);

    if (resetBtn) {
        resetBtn.addEventListener('click', reiniciarFiltros);
    }


    function primerLoad() {
        searchInfiniteScroll({
            getFiltros: () => filtros
        });
    }

    function aplicarFiltros(e) {
        e.preventDefault();

        const formData = new FormData(form);
        filtros = new URLSearchParams(formData).toString();

        resetResultados();

        searchInfiniteScroll({
            getFiltros: () => filtros,
            reset: true
        });
    }

    function reiniciarFiltros() {
        form.reset();
        filtros = '';

        resetResultados();

        searchInfiniteScroll({
            getFiltros: () => filtros,
            reset: true
        });
    }

    function resetResultados() {
        container.innerHTML = '';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function cargarMarcas() {
        let offset = 0;
        const limit = 3;

        const container = document.querySelector('#brands-container');
        const btn = document.querySelector('#load-more-brands');

        if (!container || !btn) return;

        async function cargar() {
            const res = await fetch(`/api/cargar-marcas?offset=${offset}&limit=${limit}`);
            const data = await res.json();

            // ocultar botón si no hay más
            if (data.length < limit) {
                btn.style.display = 'none';
            }

            data.forEach(marca => {
                container.insertAdjacentHTML('beforeend', `
                    <label>
                        <input type="checkbox" name="brands[]" value="${marca}"> ${marca}
                    </label><br>
                `);
            });

            offset += limit;
        }

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            cargar();
        });

        cargar();
    }

    function cargarLocalizaciones() {
        let offset = 0;
        const limit = 5;

        const container = document.querySelector('#locations-container');
        const btn = document.querySelector('#load-more-locations');

        if (!container || !btn) return;

        async function cargar() {
            const res = await fetch(`/api/cargar-localizaciones?offset=${offset}&limit=${limit}`);
            const data = await res.json();

            if (data.length < limit) {
                btn.style.display = 'none';
            }

            data.forEach(loc => {
                container.insertAdjacentHTML('beforeend', `
                    <label>
                        <input type="radio" name="localizacion" value="${loc}"> ${loc}
                    </label><br>
                `);
            });

            offset += limit;
        }

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            cargar();
        });

        cargar();
    }

});
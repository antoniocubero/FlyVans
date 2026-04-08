export function searchInfiniteScroll({ getFiltros, reset = false }) {

    let pagina = 1;

    const limit = document.querySelector('#limit');
    const contenedor = document.querySelector('#search-results');

    if (!limit || !contenedor) return;

    if (reset && window.currentObserver) {
        window.currentObserver.disconnect();
    }

    const observer = new IntersectionObserver(async (entries) => {

        let entry = entries[0];

        if (entry.isIntersecting) {

            try {
                const filtros = getFiltros ? getFiltros() : '';

                const response = await fetch(`/api/cargar-anuncios?page=${pagina}&${filtros}`);
                pagina++;

                const data = await response.json();

                console.log(data);

                data.data.forEach(anuncio => {
                    contenedor.insertAdjacentHTML('beforeend', `
                        
                            <div class='card-van'>
                                <a href='/ad/${anuncio.id}'>
                                    <img src="${anuncio.caravana.foto_principal_url}">
                                    <h3>${anuncio.caravana.marca} ${anuncio.caravana.modelo}</h3>
                                    <h4>${anuncio.localizacion}</h4>
                                    <h4>
                                        ${anuncio.precio_dia}€ 
                                        ${anuncio.caravana.nota !== null 
                                            ? `- ${anuncio.caravana.nota}<span class='star'>★</span>` 
                                            : ''
                                        }
                                    </h4>
                                </a>
                            </div>
                        
                    `);
                });

            } catch (error) {
                console.error(error);
            }
        }

    }, {
        rootMargin: '100px'
    });

    observer.observe(limit);

    window.currentObserver = observer;
}
// resources/js/resultados-socket.js

const plantillaVotacion = document.getElementById('votacion-template');

if (window.Echo) {
    console.log("Echo conectado, escuchando canal 'votar'...");

    window.Echo.channel("votar").listen(".votacion.abierta", (e) => {
        const id = e.votacion_id;

        const botonVotar = document.getElementById(`votar-link-${id}`);
        const botonVerResultados = document.getElementById(`resultados-link-${id}`);
        if(!botonVotar) return;

        botonVotar.removeAttribute('hidden');
        botonVerResultados.setAttribute('hidden', 'true');        
    });

    window.Echo.channel("votar").listen(".votacion.cerrada", (e) => {
        const id = e.votacion_id;
        
        const botonVotar = document.getElementById(`votar-link-${id}`);
        const botonVerResultados = document.getElementById(`resultados-link-${id}`);
        if(!botonVotar) return;

        botonVotar.setAttribute('hidden', 'true');
        botonVerResultados.removeAttribute('hidden');
    });

    window.Echo.channel("votar").listen(".votacion.creada", (e) => {
        const votacion = e.votacion;
        const urlVotar = e.url_votar;
        const urlResultados = e.url_resultados;
        const nuevoElemento = plantillaVotacion.content.cloneNode(true);
        const uuid = localStorage.getItem('uuid');        

        //Titulo
        nuevoElemento.querySelector('.titulo').textContent = votacion.titulo;

        //Links votos
        const linkVotar = nuevoElemento.querySelector('.link-votar');
        linkVotar.href = urlVotar;
        linkVotar.id = `votar-link-${votacion.id}`;
        if (uuid) {
            linkVotar.href += '?uuid=' + encodeURIComponent(uuid);
        }
        if(votacion.estado === 'cerrada'){
            linkVotar.setAttribute('hidden','true');
        }

        //Link resultados
        const linkResultados = nuevoElemento.querySelector('.link-resultados');
        linkResultados.href = urlResultados;
        linkResultados.id = `resultados-link-${votacion.id}`;
        if(votacion.estado === 'abierta') {
            linkResultados.setAttribute('hidden', 'true');
        }

        document.getElementById('votaciones-list').appendChild(nuevoElemento);
    });
    
} else {
    console.warn("Echo no se inicializó todavía.");
}
document.addEventListener('DOMContentLoaded', function() {
                        
                    });
                    //id="votar-link-{{ $votacion->id }}"
                    //id="resultados-link-{{ $votacion->id }}"
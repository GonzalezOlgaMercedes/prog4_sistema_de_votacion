// resources/js/resultados-socket.js
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
    
} else {
    console.warn("Echo no se inicializó todavía.");
}
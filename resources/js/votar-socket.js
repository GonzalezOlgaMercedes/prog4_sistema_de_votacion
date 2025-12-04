// resources/js/resultados-socket.js
if (window.Echo) {
    console.log("Echo conectado, escuchando canal 'votar'...");

    window.Echo.channel("votar").listen(".votacion.cerrada", (e) => {
        const id = e.votacion_id;
        
        const modalId = 'modal-votacion-cerrada-' + id;
        const modal = document.getElementById(modalId);
        if(!modal) {
            return;
        }
        modal.showModal();
    });
    
} else {
    console.warn("Echo no se inicializó todavía.");
}
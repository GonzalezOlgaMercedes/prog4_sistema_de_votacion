// resources/js/resultados-socket.js
if (window.Echo) {
    console.log("Echo conectado, escuchando canal 'resultados'...");

    // CAPTURAR EVENTOS RAW DEL WEBSOCKET
    setTimeout(() => {
        try {
            const pusher = window.Echo.connector.pusher;

            pusher.connection.bind('message', function (msg) {
                console.log("⚡ Evento bruto recibido:", msg);
            });

            console.log("Debug de eventos ACTIVADO.");
        } catch (err) {
            console.warn("No pude activar debug raw:", err);
        }
    }, 1000);

    window.Echo.channel("resultados").listen(".voto.emitido", (e) => {
        console.log("Nuevo voto recibido:", e);

        const voto = e.voto;
        const opcionId = voto.opcion_id;

        // Incrementar votos de esa opción
        const texto = document.getElementById(`opcion-${opcionId}-texto`);

        // Obtener número actual de votos
        const match = texto.innerText.match(/(\d+)/);
        let votosActuales = match ? parseInt(match[1]) : 0;

        votosActuales++;

        // Actualizar total
        const totalEl = document.getElementById("total-votos");
        let totalVotos = parseInt(totalEl.innerText) + 1;
        totalEl.innerText = totalVotos;

        // Recalcular porcentaje
        const porcentaje = ((votosActuales / totalVotos) * 100).toFixed(2);

        // Actualizar texto
        texto.innerText = `${votosActuales} votos (${porcentaje}%)`;

        // Actualizar barra
        const barra = document.getElementById(`opcion-${opcionId}-barra`);
        barra.style.width = porcentaje + "%";

        // Ahora actualizar las demás opciones para mantener porcentajes correctos
        actualizarOtrasOpciones(opcionId, totalVotos);
    });
    
} else {
    console.warn("Echo no se inicializó todavía.");
}

/**
 * Recalcula los porcentajes de TODAS las opciones
 * excepto la que recién recibió voto (que ya está actualizada)
 */
function actualizarOtrasOpciones(opcionActualId, totalVotos) {
    document.querySelectorAll("[id^='opcion-'][id$='-texto']").forEach((span) => {
        const idParts = span.id.split("-");
        const opcionId = idParts[1];

        if (parseInt(opcionId) === parseInt(opcionActualId)) return;

        // Obtener votos actuales
        const match = span.innerText.match(/(\d+)/);
        const votosOpcion = match ? parseInt(match[1]) : 0;

        const porcentaje = totalVotos > 0
            ? ((votosOpcion / totalVotos) * 100).toFixed(2)
            : 0;

        // Actualizar texto
        span.innerText = `${votosOpcion} votos (${porcentaje}%)`;

        // Actualizar barra
        const barra = document.getElementById(`opcion-${opcionId}-barra`);
        if (barra) barra.style.width = porcentaje + "%";
    });
}
(function () {

    const url = 'http://instagram.com.devel/';
    //Etiquetas imgs
    const hearts = document.querySelectorAll(".heart-icon");
    //Recorrer las etiquetas img
    hearts.forEach(heart => {
        heart.addEventListener("click", (e) => {
            // Accede al elemento que activó el evento
            const elemento = e.target;
            // Accede al valor del atributo data-id a través de la propiedad 'dataset'
            const dataId = elemento.dataset.id;
            //Contador texto
            const count = document.getElementById(`n${dataId}`);
            //condicion al img corazon rojo o blanco
            if (elemento.src.includes(`${url}img/heart-red.png`)) {
                //Cambiar la fuente de la img
                elemento.src = `${url}img/heart.png`;
                //Hacer la peticion fetch
                fetch(`${url}like/delete/${dataId}`)
                        .then(response => response.json())
                        .then(data => {
                            //Actualizamos el contador a mostrar
                            //Pormedio de la variable likesCount que viene en una variable .json del controlladoe Like
                            count.textContent = `${data.likesCount}`;
                        })
                        .catch(error => console.error("Error:", error));
            } else {
                //Cambiar la fuente de la img
                e.target.src = `${url}img/heart-red.png`;
                //Hacer la peticion fetch
                fetch(`${url}like/save/${dataId}`)
                        .then(response => response.json())
                        .then(data => {
                            //Contador texto
                            count.textContent = `${data.likesCount}`;
                        })
                        .catch(error => console.error("Error:", error));
            }
        });
    });

    // --- Lógica del buscador ---
    const input = document.getElementById("inputBuscar");
    const resultados = document.getElementById("resultados");

    input.addEventListener("keyup", async (e) => {
        const query = e.target.value;

        // Actualizar la URL sin recargar
        window.history.pushState({}, "", `/user/search/${query}`);

        // Petición AJAX a Laravel
        const response = await fetch(`/user/search/${query}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        });

        if (response.ok) {
            const html = await response.text();
            resultados.innerHTML = html; // 👈 solo se mete el parcial aquí
        }
    });





})();
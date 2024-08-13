document.addEventListener("DOMContentLoaded", function () {
    // Verifica si el formulario de registro de usuario existe antes de agregar el evento
    const formUsuario = document.getElementById("form-registro-usuario");
    if (formUsuario) {
        formUsuario.addEventListener("submit", function (event) {
            event.preventDefault();
            const nombre = document.getElementById("nombre").value;
            const email = document.getElementById("email").value;

            fetch("api/usuarios.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ nombre, email }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Usuario registrado exitosamente");
                } else {
                    alert("Error al registrar usuario: " + data.message);
                }
            });
        });
    }

    // Verifica si el formulario de registro de libro existe antes de agregar el evento
    const formLibro = document.getElementById("form-registro-libro");
    if (formLibro) {
        formLibro.addEventListener("submit", function (event) {
            event.preventDefault();
            const titulo = document.getElementById("titulo").value;
            const autor = document.getElementById("autor").value;
            const genero = document.getElementById("genero").value;
            const fecha_publicacion = document.getElementById("fecha_publicacion").value;

            fetch("api/libros.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ titulo, autor, genero, fecha_publicacion }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Libro registrado exitosamente");
                } else {
                    alert("Error al registrar libro: " + data.message);
                }
            });
        });
    }

    // Recuperar y mostrar los libros en index.html
    const librosContainer = document.getElementById("libros-container");
    if (librosContainer) {
        fetch("api/libros.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.libros.forEach(libro => {
                    const card = document.createElement("div");
                    card.className = "libro-card";
                    card.innerHTML = `
                        <h3>${libro.titulo}</h3>
                        <p>Autor: ${libro.autor}</p>
                        <p>Género: ${libro.genero}</p>
                        <p>Publicado: ${libro.fecha_publicacion}</p>
                        <p>${libro.disponible ? 'Disponible' : 'No disponible'}</p>
                    `;
                    librosContainer.appendChild(card);
                });
            } else {
                alert("Error al recuperar libros: " + data.message);
            }
        });
    }

    // Recuperar y mostrar los libros en listar-libros.html
    const librosLista = document.getElementById("libros-lista");
    if (librosLista) {
        fetch("api/libros.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.libros.forEach(libro => {
                    const item = document.createElement("div");
                    item.className = "libro-item";
                    item.innerHTML = `
                        <h3>${libro.titulo}</h3>
                        <p>Autor: ${libro.autor}</p>
                        <p>Género: ${libro.genero}</p>
                        <p>Publicado: ${libro.fecha_publicacion}</p>
                        <p>${libro.disponible ? 'Disponible' : 'No disponible'}</p>
                    `;
                    librosLista.appendChild(item);
                });
            } else {
                alert("Error al recuperar libros: " + data.message);
            }
        });
    }
});

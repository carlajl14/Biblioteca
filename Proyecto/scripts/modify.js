let modificar = document.getElementById("modificar");
let enviar = document.getElementById("enviar");
let modal = document.getElementById("modal");
let bajar = document.getElementById("bajar");

const mostrar = () => {
    bajar.classList.add("bajar");
    modal.style.display = "block";
}

modificar.addEventListener("click", mostrar);

const borrar = () => {
    bajar.classList.remove("bajar");
    modal.style.display = "none";
}

enviar.addEventListener("click", borrar);
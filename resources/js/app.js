require("./bootstrap");

const perfil = document.querySelector(".dropdown");
const perfilContenido = document.querySelector(".dropdown-menu");

// Reparar repeticion de codigo en modales ,hacerlo con propagacion de eventos
const modal = document.querySelector(".modalx");
const overlay = document.querySelector(".overlay");
const btnCloseModal = document.querySelector(".btn--close-modal");
const btnsOpenModal = document.querySelector(".btn--show-modal");

const sessionsForm = document.querySelector(".save-btn");

const toggler = document.querySelector(".navbar-toggler");

///////////////////////////////////////
// Perfil

/*
perfil.addEventListener("click", function (e) {
    perfilContenido.classList.toggle("show");
    console.log("RAA");
});
*/
// Modal window

const openModal = function (e) {
    e.preventDefault();
    modal.classList.remove("hidden");
    overlay.classList.remove("hidden");
};
const closeModal = function (e) {
    e.preventDefault();
    modal.classList.add("hidden");
    overlay.classList.add("hidden");
};

btnsOpenModal.addEventListener("click", openModal);
btnCloseModal.addEventListener("click", closeModal);

// close all

toggler.addEventListener("click", function (e) {
    e.preventDefault();
    perfilContenido.classList.remove("show");
});

//

// URL

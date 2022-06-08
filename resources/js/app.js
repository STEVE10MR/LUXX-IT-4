require("./bootstrap");

const perfil = document.querySelector(".dropdown");
const perfilContenido = document.querySelector(".dropdown-menu");

// Reparar repeticion de codigo en modales ,hacerlo con propagacion de eventos
const modal = document.querySelector(".modalx");
const modalEdit = document.querySelector(".modale");
const modalRegister = document.querySelector(".modalr");
const overlay = document.querySelector(".overlay");
const btnCloseModal = document.querySelector(".btn--close-modal");

const sorted = document.querySelector(".sorted");

//const btnsOpenModal = document.querySelector(".btn--show-modal");

const btnCloseModalRegister = document.querySelector(".btn--close-registro");
const btnsOpenModalRegister = document.querySelector(".btn--show-registro");

const btnsOpenModalEdit = document.querySelector(".btn--show-editar");
const btnsCloseModalEdit = document.querySelector(".btn--close-editar");

const btnsOpenModalLogin = document.querySelector(".btn--show-login");

var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

const sessionsForm = document.querySelector(".save-btn");

const toggler = document.querySelector(".navbar-toggler");

///////////////////////////////////////
// Modal window

btnsOpenModalLogin.addEventListener("click", function (e) {
    modal.classList.remove("hidden");
    overlay.classList.remove("hidden");
    console.log("Edit open");
});

btnCloseModal.addEventListener("click", function (e) {
    e.preventDefault();
    modal.classList.add("hidden");
    overlay.classList.add("hidden");
    console.log("Edit open");
});

////

////

btnsOpenModalEdit.addEventListener("click", function (e) {
    e.preventDefault();
    modalEdit.classList.remove("hidden");
    overlay.classList.remove("hidden");
});

btnsCloseModalEdit.addEventListener("click", function (e) {
    e.preventDefault();
    modalEdit.classList.add("hidden");
    overlay.classList.add("hidden");
});

btnsOpenModalRegister.addEventListener("click", function (e) {
    e.preventDefault();
    modalRegister.classList.remove("hidden");
    overlay.classList.remove("hidden");
});

btnCloseModalRegister.addEventListener("click", function (e) {
    e.preventDefault();
    modalRegister.classList.add("hidden");
    overlay.classList.add("hidden");
    console.log("Prueba R");
});

/*
const openModal = function (e) {
    e.preventDefault();
    modal.classList.remove("hidden");
    overlay.classList.remove("hidden");
    console.log("Edit open");
};
const closeModal = function (e) {
    e.preventDefault();
    modal.classList.add("hidden");
    overlay.classList.add("hidden");
    console.log("Edit open");
};
*/

//btnCloseModal.addEventListener("click", closeModal);

// close all
toggler.addEventListener("click", function (e) {
    e.preventDefault();
    perfilContenido.classList.remove("show");
});

//
toggleButton.onclick = function () {
    el.classList.toggle("toggled");
};

// URL

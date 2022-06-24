const { type } = require("jquery");

require("./bootstrap");

("use strict");

const perfil = document.querySelector(".dropdown");
const perfilContenido = document.querySelector(".dropdown-menu");

const linkMaster = document.querySelector(".link-master");
const btnCloseEdit = document.querySelector(".deactivate-modal");

//.burbuje-edit
// Reparar repeticion de codigo en modales ,hacerlo con propagacion de eventos
const modal = document.querySelectorAll(".modalx");
const overlay = document.querySelector(".overlay");

const sorted = document.querySelector(".sorted");

const btnsOpenModal = document.querySelectorAll(".btn--show-modal");
const btnsCloseModal = document.querySelectorAll(".btn--close-modal");
const linkStatusActive = document.querySelectorAll(".link-status-a");
const linkStatusDesact = document.querySelectorAll(".link-status-d");

/*
const btnCloseModalRegister = document.querySelector(".btn--close-registro");
const btnsOpenModalRegister = document.querySelector(".btn--show-registro");

//
const btnsOpenModalEdit = document.querySelector(".btn--show-editar");
const btnsCloseModalEdit = document.querySelector(".btn--close-editar");

const btnsOpenModalLogin = document.querySelector(".btn--show-login");

*/
var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

const sessionsForm = document.querySelector(".save-btn");

const toggler = document.querySelector(".navbar-toggler");

///////////////////////////////////////

const subject = document.querySelector(".subject");
const subjectClose = document.querySelector(".subject_close");
//////////////////////////////////////

///
if (subjectClose) {
    subjectClose.addEventListener("click", function (e) {
        subject.classList.add("hidden");
    });
}

const functionOpenModal = function (modal) {
    if (
        modal.classList.contains("login") &&
        this.currentTarget.classList.contains("login")
    ) {
        modal.classList.remove("hidden");
        overlay.classList.remove("hidden");
    }
    if (
        modal.classList.contains("register") &&
        this.currentTarget.classList.contains("register")
    ) {
        modal.classList.remove("hidden");
        overlay.classList.remove("hidden");
        console.log("Open Register");
    }
};

const functionCloseModal = function (modal) {
    if (
        modal.classList.contains("login") &&
        this.currentTarget.classList.contains("login")
    ) {
        modal.classList.add("hidden");
        overlay.classList.add("hidden");
    }
    if (
        modal.classList.contains("register") &&
        this.currentTarget.classList.contains("register")
    ) {
        modal.classList.add("hidden");
        overlay.classList.add("hidden");
        console.log("Close Register");
    }
};

btnsOpenModal.forEach(function (item) {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        modal.forEach(functionOpenModal.bind(e));
    });
});

btnsCloseModal.forEach(function (item) {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        modal.forEach(functionCloseModal.bind(e));
    });
});

if (linkMaster) {
    linkMaster.addEventListener("click", function (e) {
        const element = e.target;

        if (!element.classList.contains("active-modal")) return;
        const id = element.parentNode.dataset.id;
        const modalEditId = document.getElementById("modalEdit" + id);
        modalEditId.classList.remove("hidden");
        overlay.classList.remove("hidden");
    });
}

if (btnCloseEdit) {
    btnCloseEdit.addEventListener("click", function (e) {
        const elementClose = e.target;
        if (!elementClose.classList.contains("modal-close")) return;
        const id = elementClose.dataset.id;
        const modalEditId = document.getElementById("modalEdit" + id);
        modalEditId.classList.add("hidden");
        overlay.classList.add("hidden");
    });
}

if (toggleButton) {
    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
}

const header = document.querySelector("#header");

window.onload = function () {
    document.querySelector("#account") ? document.querySelector("#account").classList.remove("hidden") : ''
    document.querySelector("#modal") ? document.querySelector("#modal").classList.remove("hidden") : ''
}

window.onscroll = function () {
    const fixed = header.offsetTop;
    if (window.pageYOffset > fixed) {
        header.classList.add("navbar-fixed");
    } else {
        header.classList.remove("navbar-fixed");
    }
};

const swiper = new Swiper(".swiper", {
    // Autoplay
    autoplay: {
        delay: 3000,
    },
    // Optional parameters
    direction: "horizontal",
    loop: true,
    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

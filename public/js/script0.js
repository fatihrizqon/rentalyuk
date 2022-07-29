/* Navbar Controls */
const hamburger = document.querySelector("#hamburger");
const close = document.querySelector("#close");
const x = document.querySelector("#x");
const navigation = document.querySelector("#navigation");
const account_button = document.querySelector("#account-button");
const account_dropdown = document.querySelector("#account-dropdown");
const sidenav_button = document.querySelector("#sidenav-button");
const shrink = document.querySelector("#shrink");
const expand = document.querySelector("#expand");
const sidenav = document.querySelector("#sidenav");
const wrapper = document.querySelector("#wrapper");
const sidenav_list = document.querySelectorAll("#sidenav ul .sidenav-list");
const sidenav_link = document.querySelectorAll(".sidenav-link");
const header = document.querySelector("#header");
const loader = document.querySelector("#header");

window.onscroll = function () {
    const fixed = header.offsetTop;
    if (window.pageYOffset > fixed) {
        header.classList.add("navbar-fixed");
        hamburger.classList.remove("hidden");
        navigation.classList.add("hidden");
        close.classList.add("hidden");
    } else {
        header.classList.remove("navbar-fixed");
    }
};

sidenav_button.addEventListener("click", function () {
    sidenav.classList.toggle("hidden");
});

expand.addEventListener("click", function () {
    expand.classList.toggle("hidden");
    shrink.classList.toggle("hidden");
    sidenav_link.forEach(s => s.classList.toggle("hidden"));
});

shrink.addEventListener("click", function () {
    expand.classList.toggle("hidden");
    shrink.classList.toggle("hidden");
    sidenav_link.forEach(s => s.classList.toggle("hidden"));
});

account_button.addEventListener("click", function () {
    account_dropdown.classList.toggle("hidden");
});

hamburger.addEventListener("click", function () {
    hamburger.classList.add("hidden");
    header.classList.add("navbar-fixed");
    navigation.classList.remove("hidden");
    close.classList.remove("hidden");
});

close.addEventListener("click", function () {
    hamburger.classList.remove("hidden");
    navigation.classList.add("hidden");
    close.classList.add("hidden");
});

x.addEventListener("click", function () {
    x.parentElement.classList.add('hidden');
});
/* End Navbar Controls */



/* SwiperJS */
const swiper = new Swiper(".swiper", {
    // Autoplay
    autoplay: {
        delay: 5000,
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

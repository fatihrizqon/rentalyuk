const shrink = document.querySelector("#shrink");
const expand = document.querySelector("#expand");
const sidenav = document.querySelector("#sidenav");
const wrapper = document.querySelector("#wrapper");
const sidenav_list = document.querySelectorAll("#sidenav ul .sidenav-list");
const sidenav_link = document.querySelectorAll(".sidenav-link");
const currentLocation = location.href;

window.onload = function () {
    document.querySelector("#modal") ? document.querySelector("#modal").classList.remove("hidden") : ''
}


for (let i = 0; i < sidenav_list.length; i++) {
    if (sidenav_list[i].children[0].href === currentLocation) {
        sidenav_list[i].children[0].classList.add("active")
    }
}

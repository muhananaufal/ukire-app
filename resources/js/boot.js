import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

Alpine.plugin(collapse);
window.Alpine = Alpine;

if (typeof window.Livewire === "undefined") {
    Alpine.start();
}

document.addEventListener("DOMContentLoaded", () => {
    if (document.querySelector(".swiper-container")) {
        new Swiper(".swiper-container", {
            loop: true,
            autoplay: { delay: 5000 },
            pagination: { el: ".swiper-pagination", clickable: true },
        });
    }
});

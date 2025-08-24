// resources/js/boot.js

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

// Daftarkan plugin ke Alpine
Alpine.plugin(collapse);

// Buat semua library bisa diakses secara global
window.Alpine = Alpine;

// INILAH LOGIKA INTINYA
// Periksa apakah Livewire akan menginisialisasi Alpine
if (typeof window.Livewire === "undefined") {
    // Jika tidak ada Livewire, kita yang inisialisasi Alpine
    Alpine.start();
}

// Inisialisasi library lain yang tidak bergantung pada Livewire
document.addEventListener("DOMContentLoaded", () => {

    if (document.querySelector(".swiper-container")) {
        new Swiper(".swiper-container", {
            loop: true,
            autoplay: { delay: 5000 },
            pagination: { el: ".swiper-pagination", clickable: true },
        });
    }
});

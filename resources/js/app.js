import "./bootstrap";
import './boot'; // <-- Panggil "manajer" kita

// Impor semua library yang kita butuhkan
import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

// Daftarkan plugin ke Alpine
Alpine.plugin(collapse);

// Buat Alpine bisa diakses secara global
window.Alpine = Alpine;

// NYALAKAN MESIN ALPINE.JS SECARA GLOBAL
// Alpine.start();

// Inisialisasi library lain setelah halaman dimuat
document.addEventListener("DOMContentLoaded", () => {

    // Inisialisasi Swiper hanya jika elemennya ada
    if (document.querySelector(".swiper-container")) {
        new Swiper(".swiper-container", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    }
});

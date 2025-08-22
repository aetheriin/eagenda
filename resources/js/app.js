import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import '../css/app.css'; // ini app.css milik project kamu
import 'tom-select/dist/css/tom-select.css'; // ini css bawaannya tom-select
import TomSelect from "tom-select";

document.addEventListener("DOMContentLoaded", () => {
    [
        "#bagian_fungsi_id", 
        "#keamanan_surat_id", 
        "#sub_tim_id", 
        "#jenis"  
    ].forEach(sel => {
        if (document.querySelector(sel)) {
            new TomSelect(sel, {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: "Pilih opsi..."
            });
        }
    });
});


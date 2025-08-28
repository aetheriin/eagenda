import './bootstrap';
import '../css/app.css'; 
import 'tom-select/dist/css/tom-select.css'; 
import Alpine from 'alpinejs';
import TomSelect from "tom-select";

window.Alpine = Alpine;
Alpine.start();


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


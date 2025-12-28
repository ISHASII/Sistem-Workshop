import "./bootstrap";

// Flatpickr for date pickers
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

function initDatepickers(selector) {
    selector =
        selector ||
        'input.datepicker, input[name="start"], input[name="end"], input[name="tanggal"]';
    document.querySelectorAll(selector).forEach(function (el) {
        try {
            // Don't overwrite if another script already initialized this element
            if (el._flatpickr) return;
            flatpickr(el, {
                dateFormat: "Y-m-d",
                allowInput: true,
            });
        } catch (e) {
            // ignore if already initialized or flatpickr not available
        }
    });
}

// Expose globally for pages that want to re-initialize dynamically
window.initDatepickers = initDatepickers;

document.addEventListener("DOMContentLoaded", function () {
    initDatepickers();
});

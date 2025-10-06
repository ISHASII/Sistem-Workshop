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

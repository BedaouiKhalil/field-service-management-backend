export function initFlatpickr() {
    const el = document.getElementById("datetimepicker-dashboard");
    if (!el) return;

    const date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
    const defaultDate = `${date.getUTCFullYear()}-${date.getUTCMonth()+1}-${date.getUTCDate()}`;

    flatpickr(el, {
        inline: true,
        prevArrow: "<span title='Previous month'>&laquo;</span>",
        nextArrow: "<span title='Next month'>&raquo;</span>",
        defaultDate: defaultDate
    });
}

document.addEventListener("DOMContentLoaded", function() {
    var monthSelect = document.querySelector("select[name='month']");
    monthSelect.addEventListener("change", function() {
        this.form.submit();
    });
});
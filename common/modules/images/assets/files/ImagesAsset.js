$(document).ready(function () {
    $('#images-uploadedfile').on('change', function () {
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#patient_image').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    });
});
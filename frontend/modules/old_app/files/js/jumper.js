$(document).ready(function () {
    $('#vrach').change(function () {
        var url = $('#vrach').val();
        $(location).attr('href', url);
    });
});

$(document).ready(function () {

    $("#TextInput").on('treeview:checked', function (event, key) {

        $("#notes-text").val($("#notes-text").val() + textArray[key] + "\n");
    });

});
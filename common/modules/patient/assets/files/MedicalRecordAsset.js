$(document).ready(function () {

    $("#ComplaintsInput").on('treeview:checked', function (event, key) {

        $("#medicalrecords-complaints").val($("#medicalrecords-complaints").val() + complaintsArray[key] + ", ");
    });
    $("#AnamnesisInput").on('treeview:checked', function (event, key) {

        $("#medicalrecords-anamnesis").val($("#medicalrecords-anamnesis").val() + anamnesisArray[key] + ", ");
    });
    $("#RecommendationsInput").on('treeview:checked', function (event, key) {

        $("#medicalrecords-recommendations").val($("#medicalrecords-recommendations").val() + recommendationsArray[key] + ", ");
    });
    $("#PrescriptionsInput").on('treeview:checked', function (event, key) {

        $("#medicalrecords-prescriptions").val($("#medicalrecords-prescriptions").val() + prescriptionsArray[key] + ", ");
    });

    $("#objectively_choose").change(function () {
        var data = "id=" + this.value;

        $.ajax({
            url: 'get-objectively-form',
            type: 'POST',
            data: data,
            success: function (res) {
                console.log(res.form_name);
                $("#"+res.form_name).html(res.html);
                var scriptForm = document.createElement("script");
                scriptForm.type = "text/javascript";
                scriptForm.text =res.script;
                $("body").append(scriptForm);
            },
            error: function () {
                alert('Error get-objectively-form ajax request!');
            }
        });


    });

    $("#therapy_choose").change(function () {
        var data = "id=" + this.value;

        $.ajax({
            url: 'get-objectively-form',
            type: 'POST',
            data: data,
            success: function (res) {
                console.log(res.form_name);
                $("#"+res.form_name).html(res.html);
                var scriptForm = document.createElement("script");
                scriptForm.type = "text/javascript";
                scriptForm.text =res.script;
                $("body").append(scriptForm);
            },
            error: function () {
                alert('Error get-objectively-form ajax request!');
            }
        });


    });
});
$(document).ready(function () {
    let div = "<!-- Modal -->\n" +
        "<div class=\"modal fade\" id=\"find-patient-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"find-patient-modal\">\n" +
        "    <div class=\"modal-dialog\" role=\"document\">\n" +
        "        <div class=\"modal-content\">\n" +
        "            <div class=\"modal-header\">\n" +
        "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n" +
        "                <h4 class=\"modal-title\" id=\"myModalLabel\">Поиск пациента</h4>\n" +
        "            </div>\n" +
        "            <div class=\"modal-body\">\n" +

        "Поиск пациентов" +
        "<input type='text'>" +
        "<select class='form-control' id='modal_patient_list' >" +
        "<option value='1'>Иванов</option>" +
        "<option value='2'>Петров</option>" +
        "</select>" +
        "               " +
        "            </div>\n" +
        "            <div class=\"modal-footer\">\n" +
        "                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Закрыть</button>\n" +
        "                <button type=\"button\" class=\"btn btn-primary modal-find-patient-ok\">OK</button>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>\n" +
        "<!-- Modal -->";
    $('body').append(div);

    $('button.modal-find-patient-open').click(function () {
        $('body').append(div);
        $('#find-patient-modal').modal('show');
        // let invoice_id = $(this).attr('invoice-id');
        // console.log(invoice_id);
        // let action = '/invoice/manage/get-ajax-table';
        // let data = {
        //     'invoice_id': invoice_id
        // };
        // $.ajax({
        //     url: action,
        //     type: 'POST',
        //     data: data,
        //     success: function (response) {
        //         $('#find-patient-modal').html(response);
        //         $('#find-patient-modal').modal('show');
        //     },
        //     error: function () {
        //         alert('Ошибка запроса');
        //     }
        // });
    });
    $('#modal_patient_list').click(function () {
        $('#modal_patient_list').html('<option value=\'1\'>Иванов</option>' +
            '<option value=\'2\'>Петров</option>' +
            '<option value=\'2\'>Петров</option>' +
            '<option value=\'2\'>Петров</option>' +
            '<option value=\'2\'>Петров</option>' +
            '<option value=\'2\'>Петров</option>' +
            '<option value=\'2\'>Петров</option>' +
            '<option value=\'3\'>Сидоров</option>');
    });

});
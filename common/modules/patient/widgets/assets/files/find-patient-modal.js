$(document).ready(function () {

    let find_patient_modal = "<!-- Modal -->\n" +
        "<div class=\"modal fade\" id=\"find-patient-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"find-patient-modal\">\n" +
        "    <div class=\"modal-dialog\" role=\"document\">\n" +
        "        <div class=\"modal-content\">\n" +
        "            <div class=\"modal-header\">\n" +
        "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n" +
        "                <h4 class=\"modal-title\" id=\"myModalLabel\">Поиск пациента</h4>\n" +
        "            </div>\n" +
        "            <div class=\"modal-body\">\n" +

        "Поиск пациентов" +
        "<input class='form-control' id='modal_patient_find_input' type='text'>" +
        "<select class='form-control' id='modal_patient_list' size='7' >" +

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

    let new_patient_modal = "<!-- Modal -->\n" +
        "<div class=\"modal fade\" id=\"new-patient-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"new-patient-modal\">\n" +
        "    <div class=\"modal-dialog\" role=\"document\">\n" +
        "        <div class=\"modal-content\">\n" +
        "            <div class=\"modal-header\">\n" +
        "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n" +
        "                <h4 class=\"modal-title\" id=\"myModalLabel\">Новый пациент</h4>\n" +
        "            </div>\n" +
        "            <div class=\"modal-body\">\n" +
        "<form id='new_patient_form' class='validate' >" +
        "<label class='control-label' for='surname'>Фамилия</label>" +
        "<input class='form-control' id='surname' name='surname' type='text' data-msg='Введите фамилию' required><br>" +
        "<label class='control-label' for='name'>Имя</label>" +
        "<input class='form-control' id='name' name='name' type='text' data-msg='Введите имя' required><br>" +
        "<label class='control-label' for='patronymic'>Отчество</label>" +
        "<input class='form-control' id='patronymic' name='patronymic' type='text'><br>" +
        "<label class='control-label' for='phone'>Телефон</label>" +
        "<input class='form-control' id='phone' name='phone' type='text' data-msg='Введите телефон' required><br>" +
        "</form>" +
        "               " +
        "            </div>\n" +
        "            <div class=\"modal-footer\">\n" +
        "                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Закрыть</button>\n" +
        "                <button type=\"button\" class=\"btn btn-primary modal-new-patient-ok\">OK</button>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>\n" +
        "<!-- Modal -->";

    $('body').append(find_patient_modal);
    $('body').append(new_patient_modal);

    $('button.modal-find-patient-open').click(function () {
        $('#find-patient-modal').modal('show');
    });

    $('#modal_patient_list').click(function () {
        $('#modal_patient_find_input').val($('option:selected', this).text());
    });

    $('#modal_patient_find_input').on("input", function () {

        let find_string = $(this).val();
        // console.log(find_string);
        let action = '/patient/patient-find/get-patient-by-surname';
        let data = {
            'find_string': find_string
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                //  console.log(response);
                let options = '';
                $.each(response, function (id, patient) {
                    options = options + '<option value=\'' + patient.patient_id + '\'>' + patient.patient_name + ' (Карта: ' + patient.patient_id + ' Д.р.'+patient.date_of_birth +')' +'</option>';
                });
                $('#modal_patient_list').html(options);
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    });
    $('.modal-find-patient-ok').on('click', function () {
        if ($('#modal_patient_list').val() > 0) {
            let patient_name_target = $('#find_btn').attr('patient_name_target');
            let patient_id_target = $('#find_btn').attr('patient_id_target');
            $(patient_id_target).val($('#modal_patient_list').val());
            $(patient_name_target).val($('#modal_patient_find_input').val());
            $('#find-patient-modal').modal('hide');
        } else {
            alert('Выбирите пациента')
        }
    });

    $('button.new-patient-modal-open').click(function () {
        $('#new-patient-modal').modal('show');
    });

    $('.modal-new-patient-ok').on('click', function () {
        $("#new_patient_form").validate({
                rules: {
                    surname: "required",
                    name: "required",
                    phone: "required"
                },
                messages: {
                    surname: "Ведите фамилию",
                    name: "Ведите имя",
                    phone: "Ведите телефон"
                },
                submitHandler: function (form) {
                    let action = '/patient/patient-find/save-patient';
                    let data = {
                        'surname': $('#surname').val(),
                        'name': $('#name').val(),
                        'patronymic': $('#patronymic').val(),
                        'phone': $('#phone').val()
                    };
                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            let patient_name_target = $('#new_btn').attr('patient_name_target');
                            let patient_id_target = $('#new_btn').attr('patient_id_target');
                            $(patient_id_target).val(response.patient_id);
                            $(patient_name_target).val(response.patient_name);
                            $('#new-patient-modal').modal('hide');
                        },
                        error: function () {
                            alert('Ошибка запроса');
                        }
                    });
                }
            }
        );
        $("#new_patient_form").submit();
    });

    let patient_name_target = $('#find_btn').attr('patient_name_target');
    let patient_id_target = $('#find_btn').attr('patient_id_target');



    if ($(patient_id_target).val()!=''){

        $.ajax({
            url: '/patient/patient-find/get-patient-by-id',
            type: 'POST',
            data:{patient_id: $(patient_id_target).val()},
            success: function (response) {
                // console.log(response);
                $(patient_name_target).val(response);
                return response;
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    }
});
$(document).ready(function () {

    const modal = "<!-- Modal -->\n" +
        "<div class=\"modal fade\" id=\"appointment-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">\n" +
        "    <div class=\"modal-dialog\" role=\"document\">\n" +
        "        <div class=\"modal-content\">\n" +
        "            <div class=\"modal-header\">\n" +
        "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span>\n" +
        "                </button>\n" +
        "                <h4 class=\"modal-title\" id=\"myModalLabel\">Запись пациента</h4>\n" +
        "            </div>\n" +
        "            <div class=\"modal-body\">\n" +
        "                <div class=\"appointment-create\">\n" +
        "                    <h4 id=\"doctor-name\" doctor-id=''></h4>\n" +
        "                    <h4 id=\"appointment-date\"></h4>\n" +
        "\n" +
        "<form id='appointment-form' class='validate' >" +
        "                    <div class=\"appointment-form\">\n" +
        "                        <div class=\"hidden\">\n" +
        "                            <div class=\"form-group field-patient_id required\">\n" +
        "                                <label class=\"control-label\" for=\"patient_id\">Пациент</label>\n" +
        "                                <input type=\"text\" id=\"patient_id\" class=\"form-control\" name=\"patient_id\"\n" +
        "                                       aria-required=\"true\" type='text' data-msg='Выберите пациента' required>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                        <div class=\"row\">\n" +
        "" +
        "                            <div class=\"col-lg-12\" id=\"patient-name-form\">\n" +
        "</div>" +
        "                            <div class=\"col-lg-12\" id=\"patient-find-form\">\n" +
        "                                <label class=\"control-label\" for=\"patient_input_group\">Пациент</label>\n" +
        "                                <div class=\"input-group\" id=\"patient_input_group\">\n" +
        "                                    <input type=\"text\" disabled=\"disabled\" class=\"form-control\" id=\"patient_name\">\n" +
        "                                    <span class=\"input-group-btn\">\n" +
        "                                     <button\n" +
        "                                             type=\"button\"\n" +
        "                                             id=\"new_btn\"\n" +
        "                                             class=\"btn btn-primary new-patient-modal-open\"\n" +
        "                                             patient_id_target=\"#patient_id\"\n" +
        "                                             patient_name_target=\"#patient_name\">\n" +
        "                                     <span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span>\n" +
        "                                     </button>\n" +
        "                                     <button\n" +
        "                                             type=\"button\"\n" +
        "                                             id=\"find_btn\"\n" +
        "                                             class=\"btn btn-primary modal-find-patient-open\"\n" +
        "                                             patient_id_target=\"#patient_id\"\n" +
        "                                             patient_name_target=\"#patient_name\">\n" +
        "                                     <span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span>\n" +
        "                                     </button>\n" +
        "                                    </span>\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                        <div class=\"row\">\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                <div class=\"form-group field-appointment-nachnaz\">\n" +
        "                                    <label class=\"control-label\" for=\"appointment-nachnaz\">Начало приёма</label>\n" +
        "                                    <input type=\"text\" id=\"appointment-nachnaz\" class=\"form-control\"\n" +
        "                                           name=\"Appointment[NachNaz]\" value=\"\" readonly=\"readonly\">\n" +
        "\n" +
        "\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                <div class=\"form-group field-appointment-okonchnaz\">\n" +
        "                                    <label class=\"control-label\" for=\"appointment-okonchnaz\">Окончание приёма</label>\n" +
        "                                    <select id=\"appointment-okonchnaz\" class=\"form-control\"\n" +
        "                                            name=\"Appointment[OkonchNaz]\">\n" +
        "                                    </select>\n" +
        "\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                        <div class=\"row\">\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                <div class=\"form-group field-appointment-appointment_content\">\n" +
        "                                    <label class=\"control-label\" for=\"appointment-appointment_content\">Содержание\n" +
        "                                        приёма</label>\n" +
        "                                    <textarea id=\"appointment-appointment_content\" class=\"form-control\"\n" +
        "                                              name=\"Appointment[appointment_content]\" rows=\"6\"></textarea>\n" +
        "\n" +
        "                                    <div class=\"help-block\"></div>\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                <select id=\"appointment-content-list\" class=\"form-control\" size='8'>\n" +
        "                                </select>\n" +
        "\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "\n" +
        "\n" +
        "                    </div>\n" +
        "</form>" +
        "                </div>\n" +
        "            </div>\n" +
        "            <div class=\"modal-footer\">\n" +
        "                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Закрыть</button>\n" +
        "                <button type=\"button\" class=\"btn btn-primary\" id=\"submit\">Записать</button>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>";


    $('body').append(modal);

    function init_patient_id(patient_id) {
        if (patient_id != null) {
            $.ajax({
                url: '/schedule/appointment/get-patient-name',
                type: 'POST',
                data: {'patient_id': patient_id},
                success: function (response) {
                    //console.log(response);
                    $('#patient_id').val(patient_id);

                    $('#patient-find-form').hide();
                    $('#patient-name-form').html('<h4>Пациент: ' + response.fullName + '</h4>');
                    $('#patient-name-form').show();


                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        } else {

            $('#patient-name-form').hide();
            $('#patient-find-form').show();
            $("#patient_name").val('');

        }
    }

    function init_appointment_content(callback) {
        $.ajax({
            url: '/schedule/appointment/get-time-list-for-appointment-content',
            type: 'POST',
            data: {},
            success: function (response) {
                let options = '';
                $.each(response.list, function (index, value) {
                    options = options + '<option value=\'' + index + '\'>' + value + '</option>';
                });
                $('#appointment-content-list').html(options);
                $('#appointment-appointment_content').val('')
                //console.log('init');
                if (callback!=null){
                    callback();
                }
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });

    }


    function init_okonchnaz(doctor_id, date, time,callback) {

        $.ajax({
            url: '/schedule/appointment/get-time-list-for-next-appointment',
            type: 'POST',
            data: {
                'doctor_id': doctor_id,
                'date': date,
                'time': time
            },
            success: function (response) {
                let options = '';
                $.each(response.time_list, function (index, value) {
                    options = options + '<option value=\'' + index + '\'>' + value + '</option>';
                });

                $('#appointment-okonchnaz').html(options);
                $('#appointment-nachnaz').val(time);
                init_appointment_content(callback);
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });

    }

    function init_doctor_id(doctor_id) {
        $.ajax({
            url: '/schedule/appointment/get-doctor-name',
            type: 'POST',
            data: {
                'doctor_id': doctor_id,
            },
            success: function (response) {
                $('#doctor-name').attr('doctor-id', doctor_id);
                $('#doctor-name').html('Врач: ' + response);
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });

    }

    function init_date(date) {
        $('#appointment-date').attr('date', date);
        date = new Date(date);
        $('#appointment-date').html('Дата: ' + date.getDate() + '.' + (date.getMonth() + 1) + '.' + date.getFullYear());
    }

    function init_modal(data,callback=null) {
        init_date(data.date);
        init_doctor_id(data.doctor_id);
        init_patient_id(data.patient_id);
        init_okonchnaz(data.doctor_id, data.date, data.time,callback);
    }

    $('#appointment-content-list').on('change', function () {
        let text = $(('#appointment-content-list option:selected')).text();
        $('#appointment-appointment_content').val($('#appointment-appointment_content').val() + text + ' ');
    });

    function create_appointment() {

        let Appointment = {
            'PatID': $('#patient_id').val(),
            'NachNaz': $('#appointment-nachnaz').val(),
            'OkonchNaz': $('#appointment-okonchnaz').val(),
            'appointment_content': $('#appointment-appointment_content').val()
        }
        $.ajax({
            url: '/schedule/appointment/set-appointment',
            type: 'POST',
            data: {
                'doctor_id': $('#doctor-name').attr('doctor-id'),
                'date': $('#appointment-date').attr('date'),
                'Appointment': Appointment
            },
            success: function (response) {
                //console.log(response);
                //render_doctor_grid($doctor_id, $start_date); //TODO ajax update
                //alert('Пациент записан');
                $('#appointment-modal').modal('hide');
                location.reload();
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    }

    function update_appointment(appointmentId) {
        let Appointment = {
            'Id': appointmentId,
            'OkonchNaz': $('#appointment-okonchnaz').val(),
            'appointment_content': $('#appointment-appointment_content').val()
        }
        $.ajax({
            url: '/schedule/appointment/update-appointment',
            type: 'POST',
            data: {
                'Appointment': Appointment
            },
            success: function (response) {
                // console.log(response);
                //render_doctor_grid($doctor_id, $start_date); //TODO ajax update
                //alert('Пациент записан');
                $('#appointment-modal').modal('hide');
                location.reload();
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    }

    $("#submit").on('click', function () {
        if (($("#patient_id").val() == '') || ($("#patient_id").val() == null)) {
            alert('Выбирите пациента');
        } else {
            if ($("#appointmentId").length) {
                update_appointment($("#appointmentId").val());
            } else {
                create_appointment();
            }
        }
    })

    $('.btn-appointment-modal-create').on('click', function () {
        let button = $(this);
        let data =
            {
                'doctor_id': button.attr('doctor_id'),
                'appointment_day_id': button.attr('appointment_day_id'),
                'patient_id': button.attr('patient_id'),
                'date': button.attr('date'),
                'time': button.attr('time')
            };
        init_modal(data);
        if ($("#appointmentId").val() != null) {
            $("#appointmentId").remove();
        }
        $('#appointment-modal').modal('show');
    })

    function init_appointment(appointment_data) {
        //console.log(appointment_data);
        $('div.appointment-form').append('<input type=\"text\" id=\"appointmentId\" value=\"' + appointment_data.appointmentId + '\" hidden>');
        $("#appointmentId").val(appointment_data.appointmentId);
        $('#appointment-appointment_content').val(appointment_data.appointment_content);
       // console.log($('#appointment-appointment_content').val());
        $('#appointment-okonchnaz').val(appointment_data.appointment_okonchnaz);
    }

    $('.btn-appointment-modal-update').on('click', function () {
        let button = $(this);
        let data =
            {
                'doctor_id': button.attr('doctor_id'),
                'appointment_day_id': button.attr('appointment_day_id'),
                'patient_id': button.attr('patient_id'),
                'date': button.attr('date'),
                'time': button.attr('time'),
                'appointmentId': button.attr('appointmentId')
            };



        if (button.attr('appointmentId') != null) {
            let appointment_data = {
                'appointment_content': button.attr('appointment_content'),
                'appointment_okonchnaz': button.attr('OkonchNaz'),
                'appointmentId': button.attr('appointmentId')
            }
            init_modal(data,function (){
                init_appointment(appointment_data);
               // console.log('update');
            });
        }
        $('#appointment-modal').modal('show');
        return false;
    })
});
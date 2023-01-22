$(document).ready(function () {
    const modal = "<!-- Modal -->\n" +
        "<div class=\"modal fade\" id=\"TaskModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">\n" +
        "    <div class=\"modal-dialog\" role=\"document\">\n" +
        "        <div class=\"modal-content\">\n" +
        "            <div class=\"modal-header\">\n" +
        "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span>\n" +
        "                </button>\n" +
        "                <h4 class=\"modal-title\" id=\"myModalLabel\">Новая задача</h4>\n" +
        "            </div>\n" +
        "            <div class=\"modal-body\">\n" +
        "                <div class=\"call-list-tasks-form\">\n" +
        "\n" +
        "                    <form id=\"call-list-tasks-form\" action=\"\" method=\"post\" class=\"validate\">\n" +
        "                        <div hidden=\"\">\n" +
        "                            <div class=\"form-group patient_id required\">\n" +
        "                                <label class=\"control-label\" for=\"patient_id\">Пациент</label>\n" +
        "                                <input type=\"text\" id=\"patient_id\" class=\"form-control\"\n" +
        "                                       name=\"CallListTasks[patient_id]\" aria-required=\"true\">\n" +
        "\n" +
        "                               \n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "<div class='row'><div class='col-lg-12'><label class=\"control-label\" for=\"call-list-id_html\">Лист обзвона</label><div id='call-list-id_html'></div></div> </div>" +
        "                        <div class=\"row\">\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                <label class=\"control-label\" for=\"patient_input_group\">Пациент</label>\n" +
        "                                <div class=\"input-group\" id=\"patient_input_group\">\n" +
        "                                    <input type=\"text\" disabled=\"disabled\" class=\"form-control\" id=\"patient_name\">\n" +
        "                                    <span class=\"input-group-btn\">\n" +
        "    <button type=\"button\" id=\"find_btn\" class=\"btn btn-primary modal-find-patient-open\"\n" +
        "            patient_id_target=\"#patient_id\" patient_name_target=\"#patient_name\"><span\n" +
        "            class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span></button>    </span>\n" +
        "                                </div>\n" +
        "\n" +
        "                                \n" +
        "                            </div>\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                <div class=\"form-group doctor_id required\">\n" +
        "                                    <label class=\"control-label\" for=\"doctor_id\">Врач</label>\n" +
        "                                    <div id=\"doctor_id_html\">\n" +

        "                                    </div>\n" +
        "\n" +
        "                                  \n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                        <div class=\"row\">\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                <div class=\"form-group appointment_content\">\n" +
        "                                    <label class=\"control-label\" for=\"appointment_content\">Содержание\n" +
        "                                        назначения</label>\n" +
        "                                    <textarea id=\"appointment_content\" class=\"form-control\"\n" +
        "                                              name=\"CallListTasks[appointment_content]\" rows=\"6\"></textarea>\n" +
        "\n" +
        "                                  \n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                            <div class=\"col-lg-6\">\n" +
        "                                \n" +
        "                                \n" +
        "                                <select id=\"appointment-content-list\" class=\"form-control\"\n" +
        "                                        name=\"appointment-content-list\"  size='8'></select>\n" +

        "                            </div>\n" +
        "                        </div>\n" +
        "                        <div hidden=\"\">\n" +
        "                            <div class=\"form-group result required\">\n" +
        "                                <label class=\"control-label\" for=\"result\">Результат обзвона</label>\n" +
        "                                <input type=\"text\" id=\"result\" class=\"form-control\"\n" +
        "                                       name=\"CallListTasks[result]\" value=\"didnt_call\" maxlength=\"255\"\n" +
        "                                       aria-required=\"true\">\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "\n" +
        "\n" +
        "                        <div class=\"form-group note\">\n" +
        "                            <label class=\"control-label\" for=\"note\">Заметка</label>\n" +
        "                            <textarea id=\"note\" class=\"form-control\"\n" +
        "                                      name=\"CallListTasks[note]\"></textarea>\n" +
        "\n" +
        "                        </div>\n" +
        "                        <div hidden=\"\">\n" +
        "                            <div class=\"form-group call_list_id required\">\n" +
        "                                <label class=\"control-label\" for=\"call_list_id\">Лист обзвона</label>\n" +
        "                                <input type=\"text\" id=\"call_list_id\" class=\"form-control\"\n" +
        "                                       name=\"CallListTasks[call_list_id]\" value=\"2\" aria-required=\"true\">\n" +
        "\n" +
        "                                <div class=\"help-block\"></div>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                        \n" +
        "                    </form>\n" +
        "                </div>\n" +
        "            </div>\n" +
        "            <div class=\"modal-footer\">\n" +
        "                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Закрыть</button>\n" +
        "                <button type=\"button\" class=\"btn btn-primary\" id='submit'>Сохранить</button>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>";


    $('body').append(modal);


    function init_doctor_id(doctor_id) {
        $.ajax({
            url: '/schedule/call-list-tasks/get-doctor-id-select',
            type: 'POST',
            data: {
                'doctor_id': doctor_id,
            },
            success: function (response) {
                $('#doctor_id_html').html(response);
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    }

    function init_patient_id(patient_id) {
        if (patient_id != null) {
            $.ajax({
                url: '/schedule/appointment/get-patient-name',
                type: 'POST',
                data: {'patient_id': patient_id},
                success: function (response) {
                    //console.log(response);
                    $('#patient_id').val(patient_id);
                    $("#patient_name").val(response.fullName);
                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        } else {

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

    function init_call_list_id(call_list_id) {
        $.ajax({
            url: '/schedule/call-list-tasks/get-call-list-id-select',
            type: 'POST',
            data: {
                'call_list_id': call_list_id,
            },
            success: function (response) {

                $('#call-list-id_html').html(response);
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    }

    function init_note() {
        $('#note').val('');
    }

    function init_modal(data, callback = null) {

        init_doctor_id(data.doctor_id);
        init_patient_id(data.patient_id);
        init_appointment_content(callback);
        init_call_list_id(data.call_list_id);
        init_note();
    }

    $('.btn-task-modal-create').on('click', function () {
        let button = $(this);
        let data =
            {
                'doctor_id': button.attr('doctor_id'),
                'patient_id': button.attr('patient_id'),
                'call_list_id': button.attr('call_list_id'),
                'task_id': button.attr('task_id')
            };


        init_modal(data);

        if ($("#taskId").val() != null) {
            $("#taskId").remove();
        }
        $('#TaskModal').modal('show');
    })

    $('#appointment-content-list').on('change', function () {
        let text = $(('#appointment-content-list option:selected')).text();
        $('#appointment_content').val($('#appointment_content').val() + text + ' ');
    });

    function create_task() {
        let task = {
            'call_list_id': $('#call_list_id').val(),
            'doctor_id': $('#doctor_id').val(),
            'patient_id': $('#patient_id').val(),
            'appointment_content': $('#appointment_content').val(),
            'note': $('#note').val(),
        }
        $.ajax({
            url: '/schedule/call-list-tasks/create-task',
            type: 'POST',
            data: task,
            success: function (response) {
                //console.log(response);
                //render_doctor_grid($doctor_id, $start_date); //TODO ajax update
                //alert('Пациент записан');
                $('#TaskModal').modal('hide');
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
            if ($("#taskId").length) {
                update_task($("#appointmentId").val());
            } else {
                create_task();
            }
        }
    })

});
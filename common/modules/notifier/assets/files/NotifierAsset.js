$(document).ready(function () {
    $('button.send_sms').on('click', function () {

        let action = "/notifier/sms/send-appointment-notification";
        let data = {
            'appointment':$(this).attr('appointment')
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response==='error'){
                    alert('Ошибка отправки смс');
                }else {
                    alert('Смс отправлено успешно');
                }
                console.log(response)
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });

    });
});

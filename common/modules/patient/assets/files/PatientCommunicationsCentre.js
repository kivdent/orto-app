$(document).ready(async function () {

    let patient_phone;

    let params = (new URL(document.location)).searchParams;

    async function getChat(patient_id) {

        let data = {
            'patient_id': patient_id
        };

        let response = await fetch(
            '/patient/rest/get-patient-phone?patient_id=' + patient_id, {
                method: "GET",
                headers: {
                    'Accept': 'application/json'
                },
                // body: JSON.stringify(data)
            }
        );
        let result;
        if (response.ok) { // если HTTP-статус в диапазоне 200-299
            // получаем тело ответа (см. про этот метод ниже)
            result = await response.json();
            patient_phone = result.phone;
        } else {
            console.log("Ошибка HTTP: " + response.status);
            return 'error';

        }

        return {
            'id': result.phone
        }
    }


    async function getAPIKey() {
        return "3eaa202b245649d7806c836a0ba0bf86";
    }

    async function getChannelId() {

        let response = await sendGET('https://api.wazzup24.com/v3/channels');
        let chanel = response.find(chanel => chanel.transport == 'whatsapp')

        return chanel.channelId;

    }

    let channel_id = await getChannelId();
    let apiKey = await getAPIKey();

    async function sendPost(url, data) {
        let apiKey = await getAPIKey();
        let response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + apiKey
            },
            body: JSON.stringify(data)
        });
        if (response.ok) { // если HTTP-статус в диапазоне 200-299
            // получаем тело ответа (см. про этот метод ниже)
            let result;
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                try {
                    result = await response.json();
                } catch (e) {
                    result = 'ok';
                }
            } else {
                result = await response.text();
            }
            return result;

        } else {
            console.log("Ошибка HTTP: " + response.status);
            return 'error';
        }
    }

    async function sendGET(url) {
        let apiKey = await getAPIKey();

        let response = await fetch(
            url, {
                method: "GET",
                headers: {
                    Authorization: 'Bearer ' + apiKey
                }
            }
        );
        if (response.ok) { // если HTTP-статус в диапазоне 200-299
            // получаем тело ответа (см. про этот метод ниже)
            let result;
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                try {
                    result = await response.json();
                } catch (e) {
                    result = await response.text();
                }
            } else {
                result = await response.text();
            }
            return result;
        } else {
            console.log("Ошибка HTTP: " + response.status);
            return 'error';
        }
    }

    async function getCurrentUser() {

        let response = await fetch(
            '/userInterface/rest/get-current-user', {
                headers: {
                    'Accept': 'application/json'
                }
            }
        );
        if (response.ok) { // если HTTP-статус в диапазоне 200-299
            // получаем тело ответа (см. про этот метод ниже)
            let result = await response.json();

            return result;
        } else {
            console.log("Ошибка HTTP: " + response.status);
            return 'error';

        }
    }

    async function getWazzupUser() {

        let current_user = await getCurrentUser();

        let wazzupUser = await sendGET('https://api.wazzup24.com/v3/users/' + current_user.id);


        if (wazzupUser == 'error') {
            let data = [
                {
                    id: current_user.id.toString(),
                    name: current_user.name,
                    phone: ''
                }
            ];
            console.log(data);

            await sendPost('https://api.wazzup24.com/v3/users', data);
            wazzupUser = await sendGET('https://api.wazzup24.com/v3/users/' + current_user.id)
        }

        let user_div = document.getElementById('current_user');
        user_div.innerHTML = wazzupUser.name;
        return wazzupUser;
    }

    async function getIframe() {

        let url = "https://api.wazzup24.com/v3/iframe";
        let user = await getWazzupUser();

        let patient_id = params.get("patient_id");
        let chat = await getChat(patient_id);
        let data =
            {
                "user": {
                    'id': user.id,
                    'name': user.name
                },
                "scope": "card",
                "filter": [
                    {
                        "chatType": "whatsapp",
                        "chatId": chat.id
                    }
                ],
                "activeChat": {
                    "chatType": "whatsapp",
                    "chatId": chat.id
                }
            }
        ;
        let response = await sendPost(url, data);
        try {
            url = response.url;
            return url;
        } catch (err) {
            alert('Ошибка загрузки чата');
        }


    }

    $('button.send_notification_sms').on('click', function () {

        let action = "/notifier/sms/send-appointment-notification";
        let data = {
            'appointment': $(this).attr('appointment')
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response === 'error') {
                    $().alert('Ошибка отправки смс');
                } else {
                    $().alert('Смс отправлено успешно');
                }
                console.log(response);
                location.reload();
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });

    });

    async function sendWazzupMessage(phone, chatType, text, channel_id) {

        let data =
            {
                channelId: channel_id,
                // refMessageId: "61e5a375-1760-452f-ad73-5318844ffc4f",
                // crmUserId: "string-user-id",
                // crmMessageId: "string-crm-message-id",
                chatId: phone,
                chatType: chatType,
                text: text
            }
        ;
        let response = await sendPost('https://api.wazzup24.com/v3/message', data);
        return response;
    }

    async function SendWazzupMsg(text, phone) {
        //let channel_id = getChannelId();
        let response = await sendWazzupMessage(phone, 'whatsapp', text, channel_id);
        return response;
    }


    let wazzup_frame = document.getElementById('wazzup_frame');
    if (wazzup_frame) {
        wazzup_frame.setAttribute('src', await getIframe());
    } else {
        console.log('Фрейм для Wazzup не найден')
    }


    let wa_send_btn = document.getElementById('wa_send_btn');
    if (wa_send_btn) {
        let wa_msg_text = document.getElementById('wa_msg_text');
        wa_send_btn.onclick = function () {
            if (wa_msg_text.value == '') {
                alert('Пустое сообщение');
            } else {
               // let channel_id = getChannelId();
                SendWazzupMsg(wa_msg_text.value, patient_phone, channel_id)
                    .then(function (r) {

                        if (r == 'error') {
                            alert('Ошибка отправки сообщения')
                        } else {
                            alert('Сообщение отправлено');
                            wa_msg_text.value = '';
                        }
                    });
            }
        };
    } else {
        console.log('Нет кнопки отправки с id = wa_send_btn');
    }

    // async function clickHandler(event){
    //     console.log(event.target)
    // }
    // document.addEventListener("click", function (){clickHandler(event)},false);


    function sendWANotificationMsg(e) {
        e.preventDefault();

        el = e.target;

        let text = 'Здравствуйте, напоминаем, что вы назначены на приём ' + el.getAttribute('date') + ' в ' + el.getAttribute('time') +
            ' в стоматологическую клинику Орто-Премьер, по адресу '+el.getAttribute('clinic_address');//TODO создать метод по созданию сообщения

        //let channel_id = getChannelId();
        let phone;

        getChat(el.getAttribute('patient_id')).then(function (result) {
            phone = result.id
        }).then(function () {
            SendWazzupMsg(text, phone, channel_id)
                .then(function (r) {

                    if (r == 'error') {
                        alert('Ошибка отправки сообщения')
                    } else {
                        alert('Сообщение отправлено');

                        let action = "/schedule/recorder/set-notice-result";
                        let data = {
                            'appointment_id': el.getAttribute('appointmentId'),
                            'notice_result': 8
                        };
                        $.ajax({
                            url: action,
                            type: 'POST',
                            data: data,
                            success: function (response) {
                                console.log(response);
                            },
                            error: function () {
                                $().alert('Ошибка запроса изменения статуса назначения');
                            }
                        });
                    }
                });
        });
    }

    function sendSMSNotificationMsg(e) {
        e.preventDefault();
        el = e.target;

        let action = "/notifier/sms/send-appointment-notification";
        let data = {
            'appointment': el.getAttribute('appointmentId')
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response === 'error') {
                    $().alert('Ошибка отправки смс');
                } else {
                    $().alert('Смс отправлено успешно');
                }
                console.log(response)
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    }

    let wa_buttons = document.getElementsByClassName("btn-wa-notification");

    for (let wa_button of wa_buttons) {
        wa_button.addEventListener('click', () => sendWANotificationMsg(event), false);
    }

    let sms_buttons = document.getElementsByClassName("btn-sms-notification");
    for (let sms_button of sms_buttons) {
        sms_button.addEventListener('click', () => sendWANotificationMsg(event), false);
    }

    $(document).on('change', '.notice-result-select', function (e) {
        if ($(this).val() == 8) {
            sendWANotificationMsg(e);
        }
    })
});
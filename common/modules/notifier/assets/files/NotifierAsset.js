$(document).ready(function () {
    $('button.send_sms').on('click', function () {

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
                console.log(response)
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });

    });

    async function sendGET() {
        let response = await fetch(
            'https://api.wazzup24.com/v3/channels', {
                method: "GET",
                headers: {
                    Authorization: 'Bearer 3eaa202b245649d7806c836a0ba0bf86'
                }
            }
        );
        let result = await response.json();
        console.log(result);
    }

    async function getUsers() {
        let response = await fetch(
            'https://api.wazzup24.com/v3/users', {
                method: "GET",
                headers: {
                    Authorization: 'Bearer 3eaa202b245649d7806c836a0ba0bf86'
                }
            }
        );
        let result = await response.json();
        console.log(result);
    }

    async function sendPOST() {
        let url = "https://api.wazzup24.com/v3/users";
        let data = [
            {
                id: '1',
                name: 'Vladimir',
                phone: ''
            }
        ];
        let response = await fetch(
            url, {
                method: "POST",
                headers: {
                    Authorization: 'Bearer 3eaa202b245649d7806c836a0ba0bf86',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }
        );
        let result = await response.json();
        console.log(result);
    }

    async function getIframe() {
        let result = 'Не выполнено';
        let url = "https://api.wazzup24.com/v3/iframe";
        // let data =
        //     [
        //         {
        //             "user": {
        //                 'id': '1',
        //                 'name': 'Vladimir'
        //             }
        //         },
        //         {
        //             "scope": "global"
        //         }
        //     ]
        // ;
        let data =
            {
                "user": {
                    'id': '1',
                    'name': 'Vladimir'
                },
                "scope": "global",
                "filter": [
                    {
                        "chatType": "whatsapp",
                        "chatId": "79609074044"
                    }
                ],
                "activeChat": {
                    "chatType": "whatsapp",
                    "chatId": "79609074044"
                }
            }
        ;

        let response = await fetch(
            url, {
                method: "POST",
                headers: {
                    Authorization: 'Bearer 3eaa202b245649d7806c836a0ba0bf86',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }
        );

        if (response.ok) { // если HTTP-статус в диапазоне 200-299
            // получаем тело ответа (см. про этот метод ниже)
            let result = await response.json();

            return result.url;
        } else {
            return "Ошибка HTTP: " + response.status;
        }
    }

    async function sendMessage() {
        let data =
            {
                channelId: "186a063d-9a7e-4ccd-9ff9-c0121e4d7cc8",
                // refMessageId: "61e5a375-1760-452f-ad73-5318844ffc4f",
                // crmUserId: "string-user-id",
                // crmMessageId: "string-crm-message-id",
                chatId: "79132881621",
                chatType: "whatsapp",
                text: "test"
            }
        ;
        let response = await fetch("https://api.wazzup24.com/v3/message", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer 3eaa202b245649d7806c836a0ba0bf86"
            },
            body: JSON.stringify(data)
        });
        if (response.ok) { // если HTTP-статус в диапазоне 200-299
            // получаем тело ответа (см. про этот метод ниже)
            let result = await response.json();
            console.log(result.messageId);
            return result.messageId;

        } else {
            return "Ошибка HTTP: " + response.status;
        }
    }

    //let message=sendMessage();
    // message.then(responce=>console.log(responce));


    let iFrame = getIframe();
    iFrame.then(function (iFrameUrl) {
        //$('#wazzup_frame').attr('src',iFrameUrl);
        document.getElementById('wazzup_frame').setAttribute('src',iFrameUrl);
    });
    //sendPOST();
    //$('#add_user').on('click', sendPOST());

});
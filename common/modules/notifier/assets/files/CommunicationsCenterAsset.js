$(document).ready(function () {
        async function getAPIKey() {
            return "3eaa202b245649d7806c836a0ba0bf86";
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
                let result = await response.json();
                return result;
            } else {
                console.log("Ошибка HTTP: " + response.status);
                return 'error';
            }
        }

        async function getWazzupUsers() {
            let wazzupUsers = await sendGET('https://api.wazzup24.com/v3/users');
            return wazzupUsers;
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
            console.log('user_id' + wazzupUser.id);
            let user_div = document.getElementById('current_user');
            user_div.innerHTML = wazzupUser.name;
            return wazzupUser;
        }

        async function getIframe() {
            let url = "https://api.wazzup24.com/v3/iframe";
            let user = await getWazzupUser();
            let data =
                {
                    "user": {
                        'id': user.id,
                        'name': user.name
                    },
                    "scope": "global",
                    // "filter": [
                    //     {
                    //         "chatType": "whatsapp",
                    //         "chatId": "79132881621"
                    //     }
                    // ],
                    // "activeChat": {
                    //     "chatType": "whatsapp",
                    //     "chatId": "79132881621"
                    // }
                }
            ;
            let response = await sendPost(url, data);
            url = response.url;
            return url;

        }

        async function CheckWazzupUser() {
            getWazzupUser();
        }

        function SetIFrame() {
            let iFrame = getIframe();
            iFrame.then(function (iFrameUrl) {
                //$('#wazzup_frame').attr('src',iFrameUrl);
                document.getElementById('wazzup_frame').setAttribute('src', iFrameUrl);
            });
        }
        SetIFrame();
    }
)

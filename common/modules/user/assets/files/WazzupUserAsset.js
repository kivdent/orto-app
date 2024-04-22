$(document).ready(async function () {
    async function getAppUser() {
        return await sendGET('/user/rest/get-wazzup-users');
    }

    let appUsers = await getAppUser();

    async function getAPIKey() {
        return "3eaa202b245649d7806c836a0ba0bf86";
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
            let result;
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                try {
                    result = await response.json();
                }catch (e){
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
                }catch (e){
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

    async function getWazzupUsers() {
        return await sendGET('https://api.wazzup24.com/v3/users');
    }

    async function addWazzupUser() {


        let user_id = this.getAttribute('user_id').toString();
        let user_name = appUsers.find(user => user.id == user_id).name;
        let data = [
            {
                id: user_id,
                name: user_name,
                phone: ''
            }
        ];

        console.log(data);

        if (this.getAttribute('action') == 'delete') {

            let apiKey = await getAPIKey();

            let response = await fetch(
                "https://api.wazzup24.com/v3/users/"+user_id, {
                    method: "DELETE",
                    headers: {
                        Authorization: 'Bearer ' + apiKey
                    }
                }
            );
            if (response.ok) {
                alert('Удалён')
                location.reload();
            } else {
                alert("Ошибка: " + response.status);
                return 'error';
            }
        } else {
            let response = await sendPost('https://api.wazzup24.com/v3/users', data);
            if (response == 'error') {
                alert('Ошибка добавления')

            } else {
                alert('Пользователь добавлен')
                location.reload();
            }
        }
    }

    async function setUsers() {
        let apiKey = await getAPIKey();
        let wazzupUsers = await getWazzupUsers();

        appUsers.forEach(function (aUser, i, arr) {
            let wUser = wazzupUsers.find(wUser => wUser.id == aUser.id);
            let wButton = document.querySelector('button[user_id="' + aUser.id + '"]');
            wButton.onclick = addWazzupUser;
            if (typeof wUser == "undefined") {

                wButton.innerHTML = '+';
                wButton.setAttribute('action','add');
            }
        });
        // wazzupUsers.forEach(function (wUser, i, arr) {
        //     let aUser = appUsers.find(aUser => aUser.id == wUser.id);
        //     if (typeof aUser == "undefined") {
        //          fetch(
        //             "https://api.wazzup24.com/v3/users/"+wUser.id, {
        //                 method: "DELETE",
        //                 headers: {
        //                     Authorization: 'Bearer ' + apiKey
        //                 }
        //             }
        //         );
        //
        //     }
        // });

    }


    setUsers();
});
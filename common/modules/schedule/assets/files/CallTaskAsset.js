$(document).ready(function () {
    const PRESENCE_CHANGE = 'change';
    const PRESENCE_NOT_CHANGE = 'not_change';

    function setNoticeResultHTML(notice_result, html) {
        // console.log(notice_result)
        $(notice_result).html(html);
    }


    function setNoticeResult(notice, change, notice_result = 'none') {
        notice.siblings('.load').show();
        let call_list_task_id = $(notice).attr('call-list-task_id');
        let action = "";

        let data = {};
        if (change === PRESENCE_CHANGE) {
            action = "/schedule/call-list-tasks/set-notice-result";
            data = {
                'call-list-task_id': call_list_task_id,
                'notice_result': notice_result
            };
        } else {
            action = "/schedule/call-list-tasks/get-notice-result";
            data = {
                'call-list-task_id': call_list_task_id
            };
        }
        // console.log(data);
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                // console.log(response);
                setNoticeResultHTML(notice, response.html);
            },
            error: function () {
                $().alert('Ошибка запроса');
            }
        });

        notice.siblings('.load').hide();
    }

    function setAllNoticeResultStatus() {
        $('.notice-result').each(function (item, value) {
            setNoticeResult($(this), PRESENCE_NOT_CHANGE);
        })
    }

    setAllNoticeResultStatus();

    $(document).on('change', '.notice-result-select', function () {
        let parent_div = $(this).parent();
        let notice_result=$(this).val();
        setNoticeResult(parent_div, PRESENCE_CHANGE,notice_result)
    })
})
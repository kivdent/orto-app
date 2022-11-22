$(document).ready(function () {
    const PRESENCE_CHANGE = 'change';
    const PRESENCE_NOT_CHANGE = 'not_change';

    const ELEMENT_SHOW='show';
    const ELEMENT_HIDE='hide';

    function setNoticeResultHTML(notice_result, html) {
        // console.log(notice_result)
        $(notice_result).html(html);
    }

    $('#doctor_id').on('change', function () {
        if ($(this).val() == 'all') {
            $('.doctor-grid').show();
        } else {
            $('.doctor-grid').hide();
            $('#doctor-grid-id-' + $(this).val()).show();
        }

    });
    $('#full_table').on('change', function () {
        if ($('#full_table').val() == 'full') {
            $('.appointment').show();
            $('.empty').show();
        }
        if ($('#full_table').val() == 'empty') {
            $('.appointment').hide();
            $('.empty').show();
        }
        if ($('#full_table').val() == 'appointment') {
            $('.empty').hide();
            $('.appointment').show();
        }
    });
    $('#full_table').trigger('change');

    function setNoticeResult(notice, change,notice_result='none') {
        notice.siblings('.load').show();
        let appointment_id = $(notice).attr('appointment_id');
        let action="";
        let data= {};
        if (change===PRESENCE_CHANGE){
            action = "/schedule/recorder/set-notice-result";
            data = {
                'appointment_id': appointment_id,
                'notice_result': notice_result
            };
        }else{
            action = "/schedule/recorder/get-notice-result";
            data = {
                'appointment_id': appointment_id
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
    function getPresenceStatus(presence, change) {

        presence.siblings('.load').show();
        let appointment_id = $(presence).attr('appointment_id');
        var action = "/schedule/recorder/get-presence-status";
        var data = {
            'appointment_id': appointment_id,
            'change': change
        };
        // console.log(data);
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                // console.log(response);
                setPresenceStatus(presence, response.html);
            },
            error: function () {
                $().alert('Ошибка запроса');
            }
        });

        presence.siblings('.load').hide();
    }

    function setAllPresenceStatus() {
        $('.presence').each(function (item, value) {
            getPresenceStatus($(this), PRESENCE_NOT_CHANGE);
        })
    }
    function setAllNoticeResultStatus() {
        $('.notice-result').each(function (item, value) {
            setNoticeResult($(this), PRESENCE_NOT_CHANGE);
        })
    }

    function setPresenceStatus(presence, html) {
        $(presence).html(html);
    }

    setAllPresenceStatus();
    setAllNoticeResultStatus();


    $(document).on('click', '.btn-presence', function () {
        let parent_div = $(this).parent();
        getPresenceStatus(parent_div, PRESENCE_CHANGE)
    })

    $(document).on('change', '.notice-result-select', function () {
        let parent_div = $(this).parent();
        let notice_result=$(this).val();
        setNoticeResult(parent_div, PRESENCE_CHANGE,notice_result)
    })
    $('#month-list').on('change',function () {
        document.location.href='/schedule/recorder?start_date='+$(this).val();
    })
    setTimeout(function() {
        location.reload();
    }, 120000);
})
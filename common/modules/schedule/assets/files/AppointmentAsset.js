$(document).ready(function () {
    // $('#doctor_id').on('change', function() {
    //     // if ($(this).val()=='all'){
    //     //     $('.doctor-grid').show();
    //     // }else{
    //     //     $('.doctor-grid').hide();
    //     //     $('#doctor-grid-id-'+$(this).val()).show();
    //     // }
    //     document.location.href=$(this).val();
    // });

    // if ($('#full_table').val()==1) {
    //     $('.appointment').show();
    // }
    // else
    // {
    //     $('.appointment').hide();
    // }
    //
    // $('#full_table').on('change', function() {
    //     if ($('#full_table').val()==1) {
    //         $('.appointment').show();
    //     }
    //     else
    //     {
    //         $('.appointment').hide();
    //     }
    // });

    $('#month-list').on('change',function () {
        document.location.href=$(this).val();
    })

    // $('#back').on('click',function () {
    //     document.location.href='/schedule/appointment?start_date='+$(this).attr('start_date');
    // })
    $('.btn-remove-appointment').on('click',function (e) {
        e.preventDefault();

        $.ajax({
            url: '/schedule/appointment/cancel-appointment',
            type: 'POST',
            data: {'appointment_id': $(this).attr('appointmentId')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function () {
                console.log(response);
                alert('Ошибка записи пациента');
                //location.reload();
            }
        });
    })
})
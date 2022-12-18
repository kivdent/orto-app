$(document).ready(function () {
    $('#doctor_id').on('change', function() {
        // if ($(this).val()=='all'){
        //     $('.doctor-grid').show();
        // }else{
        //     $('.doctor-grid').hide();
        //     $('#doctor-grid-id-'+$(this).val()).show();
        // }
        document.location.href=$(this).val();
    });
    if ($('#full_table').val()==1) {
        $('.appointment').show();
    }
    else
    {
        $('.appointment').hide();
    }
    $('#full_table').on('change', function() {
        if ($('#full_table').val()==1) {
            $('.appointment').show();
        }
        else
        {
            $('.appointment').hide();
        }
    });
    $('#month-list').on('change',function () {
        document.location.href=$(this).val();
    })
    $('#datePicker').on('change',function () {
        let patient_id=$(this).attr('patient_id');
        let doctor_ids=$(this).attr('doctor_ids');
        let start_date=$(this).val();
        let link='/schedule/appointment?start_date='+start_date+'&doctor_ids='+doctor_ids+'&patient_id='+patient_id;
        document.location.href=link;
    })
    // $('#back').on('click',function () {
    //     document.location.href='/schedule/appointment?start_date='+$(this).attr('start_date');
    // })
    $('.btn-remove-appointment').on('click',function () {
        $.ajax({
            url: '/schedule/appointment/cancel-appointment',
            type: 'POST',
            data: {'appointment_id': $(this).attr('appointmentId')},
            success: function (response) {
                //console.log(response);
                location.reload();
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    })
})
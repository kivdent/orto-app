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
    if ($('#full_table').val()=='true') {
        $('.appointment').show();
    }
    else
    {
        $('.appointment').hide();
    }
    $('#full_table').on('change', function() {
        if ($('#full_table').val()=='true') {
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
    // $('#back').on('click',function () {
    //     document.location.href='/schedule/appointment?start_date='+$(this).attr('start_date');
    // })
})
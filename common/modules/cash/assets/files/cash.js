$(document).ready(function () {
    $("#payment-vidopl").change(function () {
        console.log('Смена вида оплаты');
        let action = 'payment-type-form';
        let data = {
            'payment_type': $('#payment-vidopl').val(),
            'patient_id': $('#patient_id').val()
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                $('#payment-type-form').html(response);

            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    });


    $('button.modal-open').click(function () {
        let invoice_id = $(this).attr('invoice-id');
        console.log(invoice_id);
        let action = '/invoice/manage/get-ajax-table';
        let data = {
            'invoice_id': invoice_id
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                $('#invoice-modal').html(response);
                $('#invoice-modal').modal('show');
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    });



});
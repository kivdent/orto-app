$(document).ready(function () {
    var count_invoice_items = 0;
    var invoice_sum = 0;
    if (($('#loading_invoice_id').val() !== 'new') && ($('#loading_invoice_id').length > 0)) {
        load_invoice(parseInt($('#loading_invoice_id').val()))
    }

    function render_invoice(invoice_items) {

        invoice_items.forEach(function (item, i, invoice_items) {
            let id = parseInt(item.id);
            let title = item.title;
            let price = parseInt(item.price);
            let quantity = parseInt(item.quantity);
            console.log(id, title, price, quantity);
            count_invoice_items++;
            invoice_sum += price * quantity;
            $('#invoice-table-body').append('<tr class="invoice-item ' + count_invoice_items + '" id="' + id + '">\n' +
                '                    <td class="counter">' + count_invoice_items + '</td>\n' +
                '                    <td >' + title + '</td>\n' +
                '                    <td class="price" id="invoice-item-price-' + id + '">' + price + '</td>\n' +
                '                    <td><input class="quantity" id="invoice-item-quantity-' + id + '" type="number"  min="1" value="'+quantity+'"></td>\n' +
                '                    <td class="summary" id="invoice-item-summary-' + id + '">' + price + ' руб</td>\n' +
                '                    <td ><button count_item="' + count_invoice_items + '" type="button" class=" btn btn-danger btn-xs remove-item" ><i class="glyphicon glyphicon-minus"></i></button></td>\n' +
                '                </tr>'
            );


            $('#invoice-table').trigger('change');
        });
    }

    function load_invoice(invoice_id) {
        var action = "/invoice/manage/get-invoice-items";
        var data = {'invoice_id': invoice_id};
        console.log(data);

        $.ajax({
            url: action,
            type: 'POST',
            data: data,

            success: function (response) {
                console.log(response);
                render_invoice(response);
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    }

    function invoice_summary() {
        invoice_sum = 0;
        for (let i = 1; i <= count_invoice_items; i++) {
            let id = parseInt($('tr.' + i).attr('id'));
            let summary = parseInt($('#invoice-item-quantity-' + id).val()) * parseInt($('#invoice-item-price-' + id).text());
            $('#invoice-item-summary-' + id).text(summary + ' руб.');
            invoice_sum += summary;

        }
        $("#summary").text(invoice_sum + ' руб');
    }

    function save_invoice() {
        if (count_invoice_items > 0) {
            let items = [];
            for (let i = 1; i <= count_invoice_items; i++) {

                let id = parseInt($('tr.' + i).attr('id'));
                let count = parseInt($('#invoice-item-quantity-' + id).val());
                items.push({'id': id, 'quantity': count});
            }

            var action = "save-ajax";
            var data = {
                'patient_id': parseInt($("#patient_id").val()),
                'doctor_id': parseInt($("#doctor_id").val()),
                'appointment_id': parseInt($("#appointment_id").val()),
                'invoice_type': $("#invoice_type").val(),
                'items': items
            };


            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function (response) {
                    window.location = '/';
                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        } else {
            alert('Выбирите хотя бы одну манипуляцию');
        }


    }

    function update_invoice() {
        if (count_invoice_items > 0) {
            let items = [];
            for (let i = 1; i <= count_invoice_items; i++) {
                let id = parseInt($('tr.' + i).attr('id'));
                let count = parseInt($('#invoice-item-quantity-' + id).val());
                items.push({'id': id, 'quantity': count});
            }

            var action = "update-ajax";
            var data = {
                'invoice_id': $("#invoice_id").val(),
                'items': items
            };


            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function (response) {
                    //console.log(response);
                   window.location = '/';
                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        } else {
            alert('Выбирите хотя бы одну манипуляцию');
        }
    }

    function save_technical_order(){
        if (count_invoice_items > 0) {
            let items = [];
            for (let i = 1; i <= count_invoice_items; i++) {

                let id = parseInt($('tr.' + i).attr('id'));
                let count = parseInt($('#invoice-item-quantity-' + id).val());
                items.push({'id': id, 'quantity': count});
            }
            var action = "save-ajax";
            var data = {};
            $('.required-property').each(function (index, value) {
                data[$(this).attr('id')] = $(this).val();
            })
            data['items'] = items;
            console.log(data);
            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function (response) {
                   window.location = '/';
                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        } else {
            alert('Выбирите хотя бы одну манипуляцию');

        }


    }
    function update_technical_order(){
        if (count_invoice_items > 0) {
            let items = [];
            for (let i = 1; i <= count_invoice_items; i++) {

                let id = parseInt($('tr.' + i).attr('id'));
                let count = parseInt($('#invoice-item-quantity-' + id).val());
                items.push({'id': id, 'quantity': count});
            }
            var action = "update-ajax";
            var data = {};
            $('.required-property').each(function (index, value) {
                data[$(this).attr('id')] = $(this).val();
            })
            data['items'] = items;
            data['technical_order_id'] = $('#technical_order_id').val();
            console.log(data);
            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function (response) {
                   window.location = '/';
                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        } else {
            alert('Выбирите хотя бы одну манипуляцию');

        }


    }
    $(".manipulation-item").click(function () {

        let id = $(this).attr('id');
        let price = $(this).attr('price');

        invoice_sum = invoice_sum + parseInt(price);
        if ($("tr").is("#" + id)) {
            $("#invoice-item-quantity-" + id).val(parseInt($("#invoice-item-quantity-" + id).val()) + 1);

        } else {

            count_invoice_items++;
            $('#invoice-table-body').append('<tr class="invoice-item ' + count_invoice_items + '" id="' + id + '">\n' +
                '                    <td class="counter">' + count_invoice_items + '</td>\n' +
                '                    <td >' + $(this).text() + '</td>\n' +
                '                    <td class="price" id="invoice-item-price-' + id + '">' + price + '</td>\n' +
                '                    <td><input class="quantity" id="invoice-item-quantity-' + id + '" type="number"  min="1" value="1"></td>\n' +
                '                    <td class="summary" id="invoice-item-summary-' + id + '">' + price + ' руб</td>\n' +
                '                    <td ><button count_item="' + count_invoice_items + '" type="button" class=" btn btn-danger btn-xs remove-item" ><i class="glyphicon glyphicon-minus"></i></button></td>\n' +
                '                </tr>'
            );


        }
        $('#invoice-table').trigger('change');
    });


    $('#invoice-table').on('change', function () {
        invoice_summary()
    });


    $('#invoice-table').on('click', '.remove-item', function () {

        let count_item = parseInt($(this).attr('count_item'));

        $('tr.' + count_item).detach();
        count_item++;
        for (let i = count_item; i <= count_invoice_items; i++) {
            let row = $('tr.' + i);
            row.children(".counter").text(i - 1);
            row.attr('class', 'invoice-item ' + (i - 1));

        }
        count_invoice_items--;
        $('#invoice-table').trigger('change');
    });

    $('#invoice_form').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient;
        if (button.data('recipient') === 'find') {
            var recipient_class = button.data('recipient-item-class');
            recipient = '#' + button.parent().nextAll(recipient_class).first().attr('id');
        } else {
            recipient = button.data('recipient') // Extract info from data-* attributes
        }

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.calling_element').val(recipient)
    });

    $('button.submit-modal').on('click', function () {
        var modal = $('#invoice_form');

        var recipient = $(modal.find('.calling_element')).val();
        $(recipient).val(invoice_sum);
        modal.modal('hide')
    });


    $('button.submit-invoice').on('click', function () {
        if ($('#loading_invoice_id').val() == 'new') {
            save_invoice();
        } else {
            update_invoice();
        }
    });

    $('button.submit-technical-order').on('click', function () {
        if ($('#loading_invoice_id').val() == 'new') {
            save_technical_order();
        } else {
            update_technical_order();
        }
    })

    $('button.technical-order-complete').on('click', function () {
        if (confirm('Вы действительно хотите изменить статус заказ-наряда?')) {
            var action = "/invoice/technical-order/ajax-complete";
            var data = {'technicalOrderId': $(this).attr('id')};
            console.log(data);
            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function (response) {
                    window.location.reload();
                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        }

    });
('button.technical-order-complete-one').on('click', function () {
        if (confirm('Вы действительно хотите изменить статус заказ-наряда?')) {
            var action = "/invoice/technical-order/ajax-complete-one";
            var data = {'technicalOrderId': $(this).attr('id')};
            console.log(data);
            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function (response) {
                    window.location.reload();
                },
                error: function () {
                    alert('Ошибка запроса');
                }
            });
        }

    });

    $('button.clear-modal').on('click', function () {
        $('#invoice-table-body').empty();
        count_invoice_items = 0;
        invoice_sum = 0;
        $("#summary").text('0 руб');
    });
});

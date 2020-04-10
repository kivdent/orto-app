$(document).ready(function () {
    let div="<!-- Modal -->\n" +
        "<div class=\"modal fade\" id=\"invoice-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"invoice-modal\">\n" +
        "    <div class=\"modal-dialog\" role=\"document\">\n" +
        "        <div class=\"modal-content\">\n" +
        "            <div class=\"modal-header\">\n" +
        "                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n" +
        "                <h4 class=\"modal-title\" id=\"myModalLabel\">Modal title</h4>\n" +
        "            </div>\n" +
        "            <div class=\"modal-body\">\n" +
        "                ...\n" +
        "            </div>\n" +
        "            <div class=\"modal-footer\">\n" +
        "                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n" +
        "                <button type=\"button\" class=\"btn btn-primary\">Save changes</button>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>\n" +
        "<!-- Modal -->";
    $('body').append(div);

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
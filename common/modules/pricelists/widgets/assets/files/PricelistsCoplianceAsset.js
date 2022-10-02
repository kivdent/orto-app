$(document).ready(function () {
    let action_href= $('#compliance-btn').attr('href');
    $('.manipulation-item').click(function () {
        let compliance_item_id = $(this).attr('pricelist-item-id');
        $('#compliance-btn').attr('href', action_href + '&complianceItemId=' + compliance_item_id);
        $('#compliance-data').show();
        $('#manipulation-title').text('->' + $(this).text());
        // let newPricesArray = getNewPricelistArray();
        // var action = "save-draft";
        // var data = {
        //     'newPricesArray': newPricesArray
        // };
        // $.ajax({
        //     url: action,
        //     type: 'POST',
        //     data: data,
        //     success: function (response) {
        //         //console.log(response.url);
        //         //alert('Успешно');
        //         window.location = response.url;
        //     },
        //     error: function () {
        //         alert('Ошибка запроса');
        //     }
        // });
    })

});
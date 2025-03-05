$(document).ready(function () {

    function setNewPricesFromFile(newPricesArray) {
        newPricesArray.forEach(function (newPrice, index, arr) {
            $('#price-list-item-new-price-' + newPrice.id).val(newPrice.price);
            $('#price-list-item-new-coefficient-' + newPrice.id).val(newPrice.coefficient);
            $('#price-list-item-new-active-' + newPrice.id).val(newPrice.active);

        });
    }

    function getNewPricelistArray() {
        let newPricesArray = [];
        $('.price-list-item-new-price').each(function (index, element) {
            let id = $(element).attr('id').split('-')[5];
            let coefficientElementId = "#price-list-item-new-coefficient-" + $(element).attr('id').split('-')[5];
            let activeElementId = "#price-list-item-new-active-" + $(element).attr('id').split('-')[5];
            newPricesArray.push({'id': id, 'price': $(element).val(), 'coefficient': $(coefficientElementId).val(),'active':$(activeElementId).val()});

        })
        return newPricesArray;
    }

    $("#batch-editing-apply").click(function () {
        $('.price-list-item-new-price').each(function (index, element) {
                // index (число) - текущий индекс итерации (цикла)
                // данное значение является числом
                // начинается отсчёт с 0 и заканчивается количеству элементов в текущем наборе минус 1
                // element - содержит DOM-ссылку на текущий элемент


                let coefficientId = "#price-list-item-new-coefficient-" + $(element).attr('id').split('-')[5];
                let percent = $('#percent').val() / 100 + 1;
                let oldPrice = $(element).attr('old-price');
                let price = Math.ceil(oldPrice * 100 * percent) / 100;
                let oldCoefficientId = "#price-list-item-old-coefficient-" + $(this).attr('id').split('-')[5];
                if (price < 1000) {
                    if (price === Math.ceil(price / 10) * 10) {
                        price = price + 10;
                    } else {
                        price = Math.ceil(price / 10) * 10;
                    }
                }else{
                    if (price === Math.ceil(price / 100) * 100) {
                        price = price + 100;
                    } else {
                        price = Math.ceil(price / 100) * 100;
                    }
                }
                $(element).val(price);
                if ($(oldCoefficientId).val() != '0') {
                    if (oldPrice / 100 == $(oldCoefficientId).val()) {
                        $(coefficientId).val(price / 100);
                    } else {
                        $(coefficientId).val(Math.ceil($(oldCoefficientId).val() * 100 * percent) / 100);
                    }

                } else {
                    $(coefficientId).val(0);
                }

            }
        )
    });

    $('.price-list-item-new-price').on('change', function () {
        let coefficientId = "#price-list-item-new-coefficient-" + $(this).attr('id').split('-')[5];
        let oldCoefficientId = "#price-list-item-old-coefficient-" + $(this).attr('id').split('-')[5];
        if ($(oldCoefficientId).val() != '0') {
            $(coefficientId).val($(this).val() / 100);
        } else {
            $(coefficientId).val(0);
        }
    });

    $('.price-remove').on('click', function () {
        let priceElement = $(this).attr('price-element');
        let oldPrice = $(this).attr('old-price');
        console.log($(this).attr('price-element') + '+' + $(this).attr('old-price'));
        $(priceElement).val(oldPrice);
        $(priceElement).trigger('change');
    });

    $('#save-draft').click(function () {

        let newPricesArray = getNewPricelistArray();
        var action = "save-draft";
        var data = {
            'newPricesArray': newPricesArray
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                // console.log(response.url);
                // alert('Успешно');
               //window.location = response.url;
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    })

    $('#upload-draft').on('fileuploaded', function (event, data, previewId, index, fileId) {
        console.log(data.response);
        setNewPricesFromFile(data.response);
        $('#upload-draft-modal').modal('hide');
    });

    $('#batch-editing-save').click(function () {
        let newPricesArray = getNewPricelistArray();
        var action = "batch-editing-save";
        var data = {
            'newPricesArray': newPricesArray
        };
        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            success: function (response) {
                //console.log(response.url);
                //alert('Успешно');
                alert('Изменения сохранены');
                window.location = '/pricelists/manage';
            },
            error: function () {
                alert('Ошибка запроса');
            }
        });
    });
});
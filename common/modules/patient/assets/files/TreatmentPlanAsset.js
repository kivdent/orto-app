$(document).ready(function () {

    $('#treatment-plan-body').on('change', '.operation', function () {
            var data = "id=" + this.value;
            var elemets_id = this.id.split("-");
            var el_from = "#planitem-" + elemets_id[1] + "-price_from";
            var el_to = "#planitem-" + elemets_id[1] + "-price_to";
            var price_block_interval = $(this).parents('.row').siblings('.row').children('.price-block-interval');
            var price_block_price_actual = $(this).parents('.row').siblings('.row').children('.price-block-price-actual');
            var price_actual = price_block_price_actual.find('.price-actual');
            //alert(elemets_id[1]);


            $.ajax({
                url: 'prices',
                type: 'POST',
                data: data,
                success: function (res) {
                    console.log(res)
                    if (res.empty === "true") {
                        $(el_from).val("");
                        $(el_to).val("");

                        price_block_interval.css("display", "block");
                        price_block_price_actual.css("display", "none");
                    } else {
                        $(el_from).val(res.price_from);
                        $(el_to).val(res.price_to);

                        $(price_actual).val(res.actualPrice);

                        price_block_interval.css("display", "block");
                        price_block_price_actual.css("display", "none");

                        // if (res.actualPrice===null || res.actualPrice===0){
                        //     price_block_interval.css("display", "block");
                        //     price_block_price_actual.css("display", "none");
                        // }else {
                        //     price_block_interval.css("display", "none");
                        //     price_block_price_actual.css("display", "block");
                        // }
                    }


                },
                error: function () {
                    alert('Error!');
                }
            });

        }
    )
    $('#treatment-plan-body').on('keyup', '.price_from', function () {
        var price_from_value = this.value;
        var price_to = $(this).parents('.price-block-interval').find('.price_to');
        var price_to_value = Math.ceil((price_from_value * 1.15) / 10) * 10;
        price_to.val(price_to_value);
    });

    function setPrices() {
        alert('Error!');
    }


    // // "kartik-v/yii2-widget-select2"
    // var $hasSelect2 = $(widgetOptionsRoot.widgetItem).find('[data-krajee-select2]');
    //
    // if ($hasSelect2.length > 0) {
    //     $hasSelect2.each(function() {
    //         var id = $(this).attr('id');
    //         var configSelect2 = eval($(this).attr('data-krajee-select2'));
    //
    //         if ($(this).data('select2')) {
    //             $(this).select2('destroy');
    //         }
    //
    //         var configDepdrop = $(this).data('depdrop');
    //         if (configDepdrop) {
    //             configDepdrop = $.extend(true, {}, configDepdrop);
    //             $(this).removeData().off();
    //             $(this).unbind();
    //             _restoreKrajeeDepdrop($(this));
    //         }
    //
    //         // $.when($('#' + id).select2(configSelect2)).done(initSelect2Loading(id, '.select2-container--krajee'));
    //         $.when($('#' + id).select2(configSelect2)).done(initS2Loading(id, '.select2-container--krajee'));
    //         var kvClose = 'kv_close_' + id.replace(/\-/g, '_');
    //
    //         // $('#' + id).on('select2:opening', function(ev) {
    //         //     initSelect2DropStyle(id, kvClose, ev);
    //         // });
    //
    //         $('#' + id).on('select2:unselect', function() {
    //             window[kvClose] = true;
    //         });
    //
    //         if (configDepdrop) {
    //             var loadingText = (configDepdrop.loadingText) ? configDepdrop.loadingText : 'Loading ...';
    //             initDepdropS2(id, loadingText);
    //         }
    //     });
    // }


});
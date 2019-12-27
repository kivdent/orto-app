$(document).ready(function () {
    $('#treatment-plan-body').on('change', '.operation', function () {
            var data = "id=" + this.value;
            var elemets_id = this.id.split("-");
            var el_from = "#planitem-" + elemets_id[1] + "-price_from";
            var el_to = "#planitem-" + elemets_id[1] + "-price_to";
            //alert(elemets_id[1]);
            $.ajax({
                url: 'prices',
                type: 'POST',
                data: data,
                success: function (res) {
                    if (res.empty === "true") {
                        $(el_from).val("");
                        $(el_to).val("");
                        console.log(res.empty);
                    } else {
                        $(el_from).val(res.price_from);
                        $(el_to).val(res.price_to);
                        console.log(res.price_from);
                        console.log(res.price_to);
                    }


                },
                error: function () {
                    alert('Error!');
                }
            });

        }
    )

    function setPrices() {
        alert('Error!');
    }
});
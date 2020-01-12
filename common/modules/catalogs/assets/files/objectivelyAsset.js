$(document).ready(function () {
    $(".dynamicform_wrapper").on('change', '.type-select', function () {
        console.log($(this).attr("index"));
        console.log($(this).val());
        console.log($(this).attr('id'));
        let html;

        let item=$("#"+$(this).attr('id')).attr("id");
        let item_index=item.split("-");
        item_index=item_index[1];
        console.log(item_index);
        if ($(this).val() == 'template') {
            html = '<select id="objectivelysubitems-' + item_index + '-0-value" class="form-control" name="ObjectivelySubItems[' + item_index+ '][0][value]" aria-invalid="true">' +
                templateOptions + '</select>';

        } else {
            html = '<input type="text" id="objectivelysubitems-' + item_index + '-0-value" class="form-control" name="ObjectivelySubItems[' + item_index + '][0][value]" maxlength="255" aria-invalid="true">';
        };
        $("div.field-objectivelysubitems-" + item_index + "-0-value").html(html);
    });


});
$('#add_work_list').dblclick(function(){

    $('#work').val($('#work').val()+$('#add_work_list').val());
});
var month=[];
var year=[];
month[3]=$("#month option[value='']");
year[3]=$("#year option[value='']");
month[4]=$("#month option[value='']");
year[4]=$("#year option[value='']");
month[6]=$("#month option[value='']");
year[6]=$("#year option[value='']");
month[12]=$("#month option[value='']");
year[12]=$("#year option[value='']");

month[6].prop('selected', true);
year[6].prop('selected', true);
$("#per").change(function(){

var p=Number.parseInt($("#per").val());
alert(p+' '+  month[p]+' '+year[p]);
month[p].prop('selected', true);
year[p].prop('selected', true);
});
$(function (){
    $(".arrowMove").hide();
});

$(document).ready(function () {
    
    $('.divTable').sortable({
        placeholder: "highlight",
        update : function(event, ui){
            $(this).children().each(function (index){
                if($(this).attr('data-position') != (index)){
                    $(this).attr('data-position', (index)).addClass('updated');
                }
            });
            var functionName = 'column/move_column_js';
            saveNewPositions(functionName);
        }
    });
    
    
    $('table [id$=bodyTable]').sortable({
        placeholder: "highlight",
        update: function (event, ui) {
            $(this).children().each(function (index) {
                 if ($(this).attr('data-position') != (index)) {
                     $(this).attr('data-position', (index)).addClass('updated');
                 }
            });
            var functionName = 'card/move_card_js';
            saveNewPositions(functionName);
        }
    });
    
 });

function saveNewPositions(functionName) {
    var positions = [];
    $('.updated').each(function () {
       positions.push([$(this).attr('data-id'), $(this).attr('data-position')]);
       $(this).removeClass('updated');
    });

    $.ajax({
       url: functionName,
       method: 'POST',
       dataType: 'text',
       data: {
           update: 0,
           positions: positions,
       }, success: function (response) {
            console.log(response);
       }
    });
}
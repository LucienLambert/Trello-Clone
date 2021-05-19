$(function() {
    $(".arrowMove").hide();

    //move position table
    $('.divTable').sortable({
        placeholder: 'ui-state-highlight',
        forcePlaceholderSize: true,
        update: function(event, ui) {
            $(this).children().each(function(index) {
                if ($(this).attr('data-position') != (index)) {
                    $(this).attr('data-position', (index)).addClass('updated');
                }
            });
            var functionName = 'column/move_column_js';
            saveNewPositions(functionName);
        }
    });

    //move position carte dans la meme table
    $('[id$=bodyTable]').sortable({
        connectWith: "[id$=bodyTable]",
        placeholder: 'ui-state-highlight',
        forcePlaceholderSize: true,
        update: function(event, ui) {
            $(this).children().each(function(index) {
                if ($(this).attr('data-position') != (index) || $(this).parent().attr('data-idColumn') != $(this).attr('data-cardIdColumn')) {
                    //update de la position de la carte déplacé 
                    $(this).attr('data-position', (index)).addClass('updated');
                    //update de l'id column de la carte déplacé
                    $(this).attr('data-cardIdColumn', $(this).parent().attr('data-idColumn')).addClass('updated');
                }
            });
            var functionName = 'card/move_card_js';
            saveNewPositions(functionName);
        }
    });
});

function saveNewPositions(functionName) {
    var positions = [];
    $('.updated').each(function() {
        positions.push([$(this).attr('data-id'), $(this).attr('data-position'), $(this).attr('data-cardIdColumn')]);
        $(this).removeClass('updated');
    });

    $.ajax({
        url: functionName,
        method: 'POST',
        dataType: 'text',
        data: {
            update: 0,
            positions: positions,
        },
    });
}
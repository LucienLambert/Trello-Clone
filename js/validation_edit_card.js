$(function() {
    $('#titleCard').keyup(function() {
        validateTitleCard();
    });
});

function validateTitleCard(idColumn) {

    var idColumn = $('#titleCard').attr('data-idColumn');
    $('#modifCard').validate({
        rules: {
            titleCard: {
                remote: {
                    url: 'card/title_available_service',
                    type: 'post',
                    data: {
                        titleCard: function() {
                            return $('#titleCard').val();
                        },
                        column: idColumn
                    }
                },
                minlength: 3,
            }
        },
        messages: {
            titleCard: {
                remote: 'this title Card already exist',
                minlength: 'minimum 3 characters',
            }
        }
    });

}
$(function() {
    $('#idtitle').keyup(function() {
        validateTitleAddColumn();
    });
});

function validateTitleAddColumn() {
    let id = $('[name=boutonAddColumn]').attr('id');
    $('#newColumn').validate({
        rules: {
            title: {
                remote: {
                    url: 'column/title_addColumn_available_service',
                    type: 'post',
                    data: {
                        title: function() {
                            return $('#idtitle').val();
                        },
                        board: id
                    }
                },
                minlength: 3,
            }
        },
        messages: {
            title: {
                remote: 'this title Column already exist',
                minlength: 'minimum 3 characters',
            }
        }
    });
}
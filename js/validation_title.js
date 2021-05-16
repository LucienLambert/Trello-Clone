$(function() {
    $("#openViewModifTitle").click($(function() {
        $('#newTitleBoard').keyup(function() {
            validateTitleBoard();
        });
    }));
});

function validateTitleBoard() {
    $('#modifTitleBoard').validate({
        rules: {
            newTitleBoard: {
                remote: {
                    url: 'board/title_available_service',
                    type: 'post',
                    data: {
                        newTitleBoard: function() {
                            return $('#newTitleBoard').val();
                        }
                    }
                },
                required: true,
                minlength: 3,
            }
        },
        messages: {
            newTitleBoard: {
                remote: 'this title already exist',
                required: 'required',
                minlength: 'minimum 3 characters',
            }
        }
    });
};
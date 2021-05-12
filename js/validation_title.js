$(function() {
    $("#openViewModifTitle").click($(function() {
        $("input:text:first").focus();
        validateTitleBoard();
    }));
    validateTitleColumn();
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

function validateTitleColumn() {
    $('#modifTitleColumn').validate({
        rules: {
            newTitleColumn: {
                remote: {
                    url: 'board/title_available_service',
                    type: 'post',
                    data: {
                        newTitleColumn: function() {
                            return $('#newTitleColumn').val();
                        }
                    }
                },
                minlength: 3,
            }
        },
        messages: {
            newTitleColumn: {
                remote: 'this title already exist',
                minlength: 'minimum 3 characters',
            }
        }
    });
}
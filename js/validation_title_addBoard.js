$(function() {
    $('#title').keyup(function() {
        validateTitleBoardAdd();
    });
});

function validateTitleBoardAdd() {

    $('#titleBoard').validate({
        rules: {
            title: {
                remote: {
                    url: 'board/title_addBoard_available_service',
                    type: 'post',
                    data: {
                        title: function() {
                            return $('#title').val();
                        }
                    }
                },
                minlength: 3,
            }
        },
        messages: {
            title: {
                remote: 'this title already exist',
                minlength: 'minimum 3 characters',
            }
        }
    });

};
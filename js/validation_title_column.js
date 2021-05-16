$(function() {
    validateTitleColumn();
});

function validateTitleColumn() {
    id = $('[name=modifTitle]').attr('id');
    $('[id$=TitleColumn]').mousedown(function() {
        idColumn = $(this).attr('data-id');
        console.log(idColumn);
        $('[id$=modifTitleColumn]').validate({
            rules: {
                newTitleColumn: {
                    remote: {
                        url: 'column/title_available_service',
                        type: 'post',
                        data: {
                            newTitleColumn: function() {
                                return $('[id$=TitleColumn]').val();
                            },
                            board: id
                        }
                    },
                    minlength: 3,
                }
            },
            messages: {
                newTitleColumn: {
                    remote: 'this title Column already exist',
                    minlength: 'minimum 3 characters',
                }
            }
        });
    });

}
$(function() {
    $("#openViewModifTitle").click($(function() {
        $('#newTitleBoard').keyup(function() {
            validateTitleBoard();
        });
    }));
    $('#idtitle').keyup(function() {
        validateTitleAddColumn();
    });
    $('#title').keyup(function() {
        validateTitleBoardAdd();
    });
    $('#titleCard').keyup(function() {
        validateTitleCard();
    });
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
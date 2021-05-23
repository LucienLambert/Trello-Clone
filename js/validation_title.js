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
    validateAddCard();
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

function validateTitleCard() {
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
    //input php form
    id = $('[name=modifTitle]').attr('id');
    //on focus l'input (l'id de l'input)
    $('[id$=TitleColumnData]').mousedown(function() {
        //on fait l'appel ajax sur le parent de l'input (dans ce cas le form)
        $(this).parent().validate({
            rules: {
                newTitleColumn : {
                    remote: {
                        url: 'column/title_available_service',
                        type: 'post',
                        data : {
                            id: id,
                        }
                    },
                    required: true,
                    minlength: 3,
                }
            },
            messages: {
                newTitleColumn: {
                    remote: 'this title Column already exist',
                    required: 'required',
                    minlength: 'minimum 3 characters',
                }
            }
        });
    });
}



function validateAddCard() {    
    //on focus l'input (l'id de l'input)
    $('[id$=inputAddCard]').mousedown(function() {
        let idColumn = ($(this).attr('data-idColumn'));
        //on fait l'appel ajax sur le parent de l'input (dans ce cas le form)
        $(this).parent().validate({
            rules: {
                titleCard : {
                    remote: {
                        url: 'card/title_available_service',
                        type: 'post',
                        data : {
                            column: idColumn,
                        }
                    },
                    required: true,
                    minlength: 3,
                }
            },
            messages: {
                titleCard: {
                    remote: 'this title card already exist',
                    required: 'required',
                    minlength: 'minimum 3 characters',
                }
            }
        });
    });
}

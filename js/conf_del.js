$(function () {
    $("[id$=delete_board]").show();
    $("[id$=delete_column]").show();
    $(".delOrignal").hide();

    $("[id$=delete_board]").click(function () {
        let id = $(this).attr('id')
        id = id.substring(0, id.indexOf("delete_board"));
        const postFunction = function () {
            $.post("board/del_board_js/" + id, function (data) {
                window.location.replace("index.php");
            })
        }
        const closeFunction = function () {
            $(this).dialog("close");
        }
        maFunction(postFunction, closeFunction)
    });

    $("[id$=delete_column]").click(function () {
        let id = $(this).attr('id').substring(0, $(this).attr('id').indexOf("delete_column"));
        const postFunction = function () {
            $.post("column/del_column_js/" + id , function (data) {
                window.location.replace("board/board/"+ data);
            })
        }
        const closeFunction = function () {
            $(this).dialog("close");
        }
        maFunction(postFunction, closeFunction)
    });

    const maFunction = (postFunction, closeFunction) => {
        $('#confirmDialog').dialog({
            resizable: false,
            draggable: false,
            height: 250,
            width: 500,
            modal: true,
            buttons: [
                {
                    text: "Delete",
                    click: function () {
                        postFunction();
                    }
                },
                {
                    text: "Cancel",
                    click: function () {
                        closeFunction()
                    }
                }
            ]
        });
    }
});
//$div[class="delete_board"]
//div[class^="delete_board"]
$(function () {
    $("[id$=delete_board]").show();
    $("[id$=delete_column]").show();
    $("[id$=delete_card]").show();
    $(".delOrignal").hide();

    $("[id$=delete_board]").click(function () {
        let id = $(this).attr('id');
        id = id.substring(0, id.indexOf("delete_board"));
        const delFunction = function () {
            $.post("board/del_board_js/" + id, function (data) {
                window.location.replace("index.php");
            })
        }
        const closeFunction = function () {
            console.log("Entre dans closeFunction");
            $(this).dialog("close");
        }
        maFunction(delFunction, closeFunction);
    });

    $("[id$=delete_column]").click(function () {
        let id = $(this).attr('id').substring(0, $(this).attr('id').indexOf("delete_column"));
        const delFunction = function () {
            $.post("column/del_column_js/" + id , function (data) {
                window.location.replace("board/board/"+ data);
            })
        }
        const closeFunction = function () {
            console.log("Entre dans closeFunction"+ this);
            $(this).dialog("close");
        }
        maFunction(delFunction, closeFunction);
    });

    $("[id$=delete_card]").click(function () {
        let id = $(this).attr('id');
        id = id.substring(0, id.indexOf("delete_card"));
        const delFunction = function () {
            $.post("card/del_card_js/" + id, function (data) {
                window.location.replace("board/board/"+ data);
            })
        }
        const closeFunction = function () {
            console.log("Entre dans closeFunction");
            $(this).dialog("close");
        }
        maFunction(delFunction, closeFunction);
    });

    const maFunction = (delFunction, closeFunction) => {
        $('#confirmDialog').dialog({
            resizable: false,
            draggable: false,
            height: 250,
            width: 500,
            modal: true,
            buttons: [
                {
                    text: "YES",
                    click: function () {
                        delFunction();
                    }
                },
                {
                    text: "NO",
                    click: function () {
                        closeFunction();
                    }
                }
            ]
        });
    }
});
//$div[class="delete_board"]
//div[class^="delete_board"]
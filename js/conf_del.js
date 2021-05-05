$(function () {
    $("[id$=delete_board]").show();
    $("[id$=delete_column]").show();
    $(".delOrignal").hide();

    $("[id$=delete_board]").click(function () {
        let id = $(this).attr('id');
        $('#confirmDialog').dialog({
            resizable: false,
            draggable: false,
            height: 250,
            width: 500,
            modal: true,
            buttons: [
                {
                    text: "Delete",
                    click: function() {
                        id = id.substring(0,id.indexOf("delete_board"));
                        $.post("board/del_board_js/" + id, function(data){
                            alert(data);
                            window.location.replace("index.php");
                        })
                    }
                },
                {
                    text: "Cancel",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
    });

    $("[id$=delete_column]").click(function () {
        let id = $(this).attr('id');
        $('#confirmDialog').dialog({
            resizable: false,
            draggable: false,
            height: 250,
            width: 500,
            modal: true,
            buttons: [
                {
                    text: "Delete",
                    click: function() {
                        id = id.substring(0,id.indexOf("delete_column"));
                        $.post("column/del_column_js/" + id, function(data){
                            window.location.replace("board/board/"+ data);
                        })
                    }
                },
                {
                    text: "Cancel",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
    });
});


//$div[class="delete_board"]
//div[class^="delete_board"]
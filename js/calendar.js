// reécupere tableau des id des board selectionné
function inputchecked() {
    let boardChecked = [];
    let checkboxes = document.querySelectorAll('input[name="board"]:checked');
    checkboxes.forEach((checkbox) => {
        boardChecked.push(checkbox.value);
    });

    return boardChecked;
}
//couleur aléatoir pour les différent board checkbox(label)
function colorBoard() {
    let tablColor = []
    $('label').each(function() {
        var colorRandom = 'rgb(' +
            (Math.floor(Math.random() * 256)) + ',' +
            (Math.floor(Math.random() * 256)) + ',' +
            (Math.floor(Math.random() * 256)) + ')';
        let label = $(this);
        let id = label.attr('id');
        id = id.substring(0, id.indexOf("label"));
        label.css('color', colorRandom);
        tablColor.push([id, colorRandom]);
    });
    return tablColor
}

//premier affichage du calendar
window.onload = () => {
    boardTitleColor = colorBoard();
    calendar(boardTitleColor);
}

//listener sur les checkbox
$(function() {
    $('#label_checkbox').change(function() {
        calendar(boardTitleColor);
    });
});

//récupération des carte(evenements) des inputs sélectionné et affichage calendar
function calendar(boardTitleColor) {
    let checked = inputchecked();
    //récuperer les carte de tout les board 
    $.post("card/select_card_from_boards", {
            boardChecked: checked,
            color: boardTitleColor
        },
        function(data) {
            evenements = JSON.parse(data);
            viewCalendar(evenements);
        }
    );
}

//calendar option
function viewCalendar(evenements) {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'Europe/paris',
        editable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listYear'
        },
        height: 'auto',
        events: evenements,
        eventDrop: (infos) => {
            if (!confirm("Do you really want to move this card")) {
                infos.revert();
            } else {
                //à terminer pour la mise a jour de l'affichage du texte en rouge si dueDate < today
                $.post('card/update_dueDate_card_calendar_js', {
                    dueDate: infos.event.startStr,
                    idCard: infos.oldEvent.id
                });
                document.location.reload();
            }
        },
        eventClick: (infos) => {
            dialogBox(infos);
        }
    });
    calendar.render();
}

//boite modal pour afficher la carte(evenement) 
function dialogBox(infos) {
    $('#title').html(infos.event.title);
    $('#body').html(infos.event.extendedProps.description);
    $('#dueDate').html(infos.event.startStr);
    $("#modalDialog").dialog({
        resizable: false,
        draggable: false,
        height: 250,
        width: 500,
        modal: true,
        title: 'Card',
        buttons: {
            Ok: function() {
                $(this).dialog("close");
            }
        }
    });
}
// reécupere tableau des id des board selectionné
function inputchecked() {
    let boardChecked = [];
    let checkboxes = document.querySelectorAll('input[name="board"]:checked');
    console.log(checkboxes);
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
    console.log(boardTitleColor);
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
    console.log(checked);
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
            console.log(infos);
            console.log(infos.event.startStr);
            console.log(infos.oldEvent.startStr);
            if (!confirm("Etes vous sur de vouloir déplacer cette carte")) {
                infos.revert();
            } else {
                $.post('card/update_dueDate_card_calendar_js', {
                    dueDate: infos.event.startStr,
                    idCard: infos.oldEvent.id
                });
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
    console.log(infos.event.title);
    console.log(infos.event);
    console.log(infos.event.extendedProps.description);
    console.log(infos.event.startStr);
    $('#title').html(infos.event.title);
    $('#body').html(infos.event.extendedProps.description);
    $('#dueDate').html(infos.event.startStr);
    $("#modalDialog").dialog({
        resizable: false,
        draggable: false,
        height: 250,
        width: 500,
        modal: true,
        title: 'evenement',
        buttons: {
            Ok: function() {
                $(this).dialog("close");
            }
        }
    });
}
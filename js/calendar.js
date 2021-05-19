$(function() {
    window.onload = () => {
        // reécupere tableau des id des board selectionné
        let checkboxes = document.querySelectorAll('input[name="board"]:checked');
        console.log(checkboxes);
        boardChecked = [];
        checkboxes.forEach((checkbox) => {
            boardChecked.push(checkbox.value);
        });
        console.log(boardChecked);
        //couleur aléatoir pour les différent board checkbox(label)
        tablColor = []
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
        //récuperer les carte de tout les board 
        $.post("card/select_card_from_boards", {
                boardChecked: boardChecked,
                color: tablColor
            },
            function(data) {
                evenements = JSON.parse(data);
                console.log(evenements);
                viewCalendar(evenements);
            }
        );
    }
});

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
        events: evenements,
        eventDrop: (infos) => {
            /*if (infos.event.startStr > now()) {
                infos.event.el.style('text-decoration:line-through');
            }*/
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
            alert('Event: ' + infos.event.title);
            alert('Coordinates: ' + infos.jsEvent.pageX + ',' + infos.jsEvent.pageY);
            alert('View: ' + infos.view.type);
            /*$(this).click(function() {
                $('#bodyCard_dialog').modal('show');
            });*/
            //dialogBox();
        }
    });
    calendar.render();
}

function dialogBox() {
    $('#bodyCard_dialog').modal('show');

}
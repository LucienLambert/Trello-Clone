<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>Calendar</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>   
        <link href='lib/fullcalendar/lib/main.css' rel='stylesheet' />
        <script src='lib/fullcalendar/lib/main.js'></script>
        <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
        <script src="js/calendar.js" type="text/javascript"></script>
        <script>
            $(function(){
                $('label').each(function(){
                    var colorRandom = 'rgb('
                        + (Math.floor(Math.random() * 256)) + ','
                        + (Math.floor(Math.random() * 256)) + ','
                        + (Math.floor(Math.random() * 256)) + ')';
                    console.log(colorRandom);
                    //$(this).style.color = colorRandom ;
                });
            });
            
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: 'Europe/paris',
                    editable: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listYear'
                    },
                    views:{
                        timeGridWeek:{
                            Boolean, default:true
                        }
                    },
                    events: [
                        {
                        title  : 'event1',
                        start  : '2021-01-01'
                        },
                        {
                        title  : 'event2',
                        start  : '2021-01-05',
                        end    : '2021-01-05'
                        },
                        {
                        title  : 'event3',
                        start  : '2021-01-09T12:30:00',
                        allDay : false // will make the time show
                        }
                    ]
                });
                calendar.render();
            });
        </script>
    </head>
    <body>
        <?php include("header.php")?></br>
        <div id="label_checkbox">
            <form>
                <?php foreach($tablBoard as $board){?>
                    <input type="checkbox" id="<?php echo $board->getId()?>" name="<?php $board->getId()  ?>" value="<?php $board->getId()?>" checked>
                    <label  id="label" for="<?php echo $board->getId() ?>" ><?php echo $board->getTitle(); ?></label>
                <?php } ?>    
            </form>
        </div>
        <div id="calendar"></div>
       
    </body>
</html>
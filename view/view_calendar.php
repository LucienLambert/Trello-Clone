<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>Calendar</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>   
        <link href='lib/fullcalendar/lib/main.css' rel='stylesheet' />
        <link href="lib/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.structure.min.css" rel="stylesheet" type="text/css"/>
        <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
        <script src="lib/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src='lib/fullcalendar/lib/main.js'></script>
        <script src="js/calendar.js" type="text/javascript"></script>
        
    </head>
    <body>
        <?php include("header.php")?><br>
        
        <div id="label_checkbox">
            <form>
                <?php foreach($tablBoard as $board){?>
                    <input onchange="inputchecked()"  type="checkbox" id="<?php echo $board->getId() . 'idBoard';?>" name="board" value="<?php echo $board->getId()?>" checked>
                    <label id="<?php echo $board->getId() .'label' ?>" for="<?php echo $board->getId() ?>" ><?php echo $board->getTitle(); ?></label>
                <?php } ?>    
            </form>
        </div>
        <div id="calendar"></div>
        <div id="modalDialog" hidden>
            <h5>TitleCard : <span id="title"> </span></h5>
            <h5>Body : <span id="body"> </span></h5>
            <h5>DueDate : <span id="dueDate"> </span></h5>
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>Calendar</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>   
        <link href='lib/fullcalendar/lib/main.css' rel='stylesheet' />
        
        <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
        <script src='lib/fullcalendar/lib/main.js'></script>
        <script src="js/calendar.js" type="text/javascript"></script>
        
    </head>
    <body>
        <?php include("header.php")?></br>
        
        <div id="label_checkbox">
            <form>
                <?php foreach($tablBoard as $board){?>
                    <input type="checkbox" id="<?php echo $board->getId() . 'idBoard';?>" name="board" value="<?php echo $board->getId()?>" checked>
                    <label id="<?php echo $board->getId() .'label' ?>" for="<?php echo $board->getId() ?>" ><?php echo $board->getTitle(); ?></label>
                <?php } ?>    
            </form>
        </div>
        <div id="calendar">
            <div id="bodyCard_dialog" titre="Carte" hidden>
                p>carte</p>
            </div> 
        </div>
    </body>
</html>
<!DOCTYPE>
<html>
<head>
    <head>
        <meta charset="UTF-8">
        <title>delete confirm</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
</head>
<p><a href="board/index">Home</a></p>
<body>
        <div>
            <h1>Are you sure ?</h1>
            <p>Do you really want to delete this <?php echo $objectNotif ?></p>
            <p>This process cannot be undone.</p>
            <!-- formulaire pour cancel l'action (annuler la suppression) -->
            <form action="card/delete_card/" method="post">
                <input type="submit" name="butonCancel" value="Cancel">
            </form>
            <!-- formulaire pour accepter l'action (supprime le board, card ou column)-->
            <form action="<?php echo $function?>/delete_<?php echo $function?>/<?php echo $object->getId()?>" method="post">
                <input type="submit" name="butonDelete" value="Delete">
            </form>
            <p><?php echo $resultat ?> </p>
        </div>
    </body>
</html>

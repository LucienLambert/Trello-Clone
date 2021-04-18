<!DOCTYPE>
<html lang="en-US">
<head>
    <head>
        <meta charset="UTF-8">
        <title>delete confirm</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
</head>
<body>
<?php include("header.php") ?>
        <div id="delete">
            <h1 id="TrashIcon">&#128465;</h1>
            <h1>Are you sure ?</h1>
            <p>Do you really want to delete this <?php echo $objectNotif ?></p>
            <p>This process cannot be undone.</p>
            <!-- formulaire pour cancel l'action (annuler la suppression) -->
            <form action="<?php echo $function?>/delete_<?php echo $function?>/<?php echo $object->getId()?>/<?php echo $board->getId() ?>" method="post">
                <input style="background-color: green;" type="submit" name="butonCancel" value="Cancel">
            </form>
            <!-- formulaire pour accepter l'action (supprime le board, card ou column)-->
            <form action="<?php echo $function?>/delete_<?php echo $function?>/<?php echo $object->getId()?>" method="post">
                <input style="background-color: red;" type="submit" name="butonDelete" value="Delete">
            </form>
            
        </div>
    </body>
</html>

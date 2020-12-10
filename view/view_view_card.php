<!DOCTYPE>
<html>
    <head>
        <head>
            <meta charset="UTF-8">
            <title>Edit Card</title>
            <base href="<?= $web_root ?>"/>
            <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        </head>
    </head>
    <body>
    <div>
        <p><a href="board/index">Home</a> <a href="board/board/<?php echo $column->board?>">Board</a></p>
    </div>
    <h1>Card "<?php echo $card->getTitle() ?>"</h1>
    <!-- formulaire pour supprimer le board -->
    <form class="FormColumn" action="board/delete_card" method="post">
        <input type="submit" name="delBoard" value="Delete Board">
    </form>
    <!-- formulaire pour afficher l'option modifier la carte -->
    <?php if (!$viewEditTitleCard) : ?>
        <form class="FormColumn" action="board/edit_card/<?php echo $column->id ?>/<?php echo $card->getId() ?>" method="post">
            <input type="submit" name="openViewModifCard" value="modify Card">
        </form>
    <?php endif; ?>
    <p>
        <?php echo "Créated " . $diffDate . " " . $messageTime . " ago by " . $fullName . "." ?>
        <?php if (!$modifDate) {
            echo $messageTimeModif;
        } else {
            echo "Modified " . $diffDateModif . " " . $messageTimeModif . " ago";
        } ?>
    </p>
    <p>
        this card is on the board "<?php echo$board->title?>", column "<?php echo $column->title?>" at position <?php echo $column->position?>;
    </p>
    <h3>Body</h3>
    <textarea name="bodyCard" disabled="disabled" rows="5" cols="100"><?php echo $card->getBody() ?></textarea>
    </body>
</html>

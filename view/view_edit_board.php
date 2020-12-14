<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit board</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>
<div>
    <a href="board/index">board</a>
</div>
<body>
<h1>Board "<?php echo $board->title ?>"</h1>
<!-- formulaire pour supprimer le board -->
<form class="FormColumn" action="board/delete_board" method="post">
    <input type="submit" name="delBoard" value="Delete Board">
</form>
<!-- formulaire pour afficher l'option modifier le titre du board -->
<?php if (!$viewEditTitleBoard) : ?>
    <form class="FormColumn" action="board/board/<?php echo $board->id ?>" method="post">
        <input type="submit" name="openViewModifTitle" value="modify Board">
    </form>
<?php else: ?>
    <!-- formulaire pour modifier le titre du board -->
    <form class="FormColumn" action="board/edit_title_board/<?php echo $board->id ?>" method="post">
        <input type="text" name="newTitleBoard" size="15" placeholder="Enter a new Title">
        <input type="submit" name="modifTitle" value="apply">
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

<?php foreach ($tableColumn as $column) { ?>
    <!-- ajout condition  -->
    <table style="display:inline">
        <thead>
        <tr>
            <th>
                <?php echo $column->title ?>
                <!-- formulaire pour modifier le title de la colonne -->
                <form action="board/edit_title_column/<?php echo $column->board ?>/<?php echo $column->id ?>"
                      method="post">
                    <input type="text" name="newTitleColumn" size="15" placeholder="Enter a new Title">
                    <input type="submit" name="modifTitle" value="Apply">
                </form>
                <form action="board/delete_column/<?php echo $column->board ?>/<?php echo $column->id ?>"
                      method="post">
                    <input type="submit" name="butonDelColumn" value="Delete">
                </form>
                <?php if ($column->position == 0) { ?>
                    <!-- formulaire déplacement à droite -->
                    <form action="board/move_right_column/<?php echo $column->board ?>/<?php echo $column->id ?>"
                          method="post">
                        <input type="submit" name="move" value="->">
                    </form>
                <?php } elseif ($column->position < count($tableColumn) - 1) { ?>
                    <!-- formulaire déplacement à gauche -->
                    <form action="board/move_left_column/<?php echo $column->board ?>/<?php echo $column->id ?>"
                          method="post">
                        <input type="submit" name="move" value="<-">
                    </form>
                    <!-- formulaire déplacement à droite -->
                    <form action="board/move_right_column/<?php echo $column->board ?>/<?php echo $column->id ?>"
                          method="post">
                        <input type="submit" name="move" value="->">
                    </form>
                <?php } else { ?>
                    <!-- formulaire déplacement à gauche -->
                    <form action="board/move_left_column/<?php echo $column->board ?>/<?php echo $column->id ?>"
                          method="post">
                        <input type="submit" name="move" value="<-">
                    </form>
                <?php } ?>
            </th>
        </tr>
        </thead>
        <?php foreach ($tableCardColumn[$column->position] as $card) { ?>
            <tbody>
                <!-- formulaire pour ouvrir une carte-->
                <form action="board/view_card/<?php echo $column->id?>/<?php echo $card->getId()?>" method="post">
                    <tr>
                        <td><input type="submit" name="openCard" value="<?php echo $card->getTitle() ?>"></td>
                    </tr>
                </form>
            </tbody>
        <?php } ?>
        <tfoot>
        <tr>
            <!-- formulaire pour ajouter une carte-->
            <form action="board/add_Card/<?php echo $column->board ?>/<?php echo $column->id ?>" method="post">
                <td><input type="text" name="titleCard" size="15" placeholder="Add Card">
                    <input type="submit" name="boutonAddCard" value="Add">
                </td>
            </form>
        </tr>
        </tfoot>
    </table>
<?php } ?>
<!--formulaire qui s'occupe d'ajouter une colonne au baurd-->
<form class="FormColumn" action="board/add_column/<?php echo $board->id ?>" method="post">
    <td>
        <input type="text" name="title" size="15" placeholder="Add a column">
        <input type="submit" name="boutonAddColumn" value="Add">
    </td>
</form>

<?php if (count($error) > 0) { ?>
    <p>Please check the errors and correct them :</p>
    <ul>
        <?php foreach ($error as $err) { ?>
            <li><?php echo $err ?></li>
        <?php } ?>
    </ul>
<?php } ?>
</body>
</html>

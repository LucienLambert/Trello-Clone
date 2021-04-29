<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Edit board</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui.structure.min.css" rel="stylesheet" type="text/css"/>
    <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="js/conf_del.js" type="text/javascript"></script>
    <script src="lib/jquery-ui.min.js" type="text/javascript"></script>
</head>
<body>
<?php include("header.php") ?>
<h1>Board "<?php echo $board->getTitle() ?>"</h1>
<?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
    <!-- formulaire pour supprimer le board -->
    <form action="board/delete_board/<?php echo $board->getId() ?>" method="post">
        <input id="<?php echo $board->getId().'delete_board';?>" type="button" name="id_board" value="Delete Board" hidden>
        <input id="delOrignal" type="submit" name="delBoard" value="Delete Board">
    </form>

    <div id="confirmDialog" title="Delete Board" hidden>
        <p>do you really want to delete this board ("<?php echo $board->getTitle()?>")</p>
    </div>

    <!-- formulaire pour afficher l'option modifier le titre du board -->
    <?php if (!$viewEditTitleBoard) : ?>
        <form action="board/board/<?php echo $board->getId() ?>" method="post">
            <input type="submit" name="openViewModifTitle" value="modify Board">
        </form>
    <?php else: ?>
        <!-- formulaire pour modifier le titre du board -->
        <form action="board/edit_title_board/<?php echo $board->getId() ?>" method="post">
            <input type="text" name="newTitleBoard" size="15" placeholder="Enter a new Title">
            <input type="submit" name="modifTitle" value="apply">
        </form>
    <?php endif; ?>
    <form action="board/collaborators/<?php echo $board->getId() ?>" method="post">
        <input type="submit" name="view_collaborator" value="Collaborator">
    </form>
<?php } ?>
<p>
    <?php echo "Créated " . $diffDate . " " . $messageTime . " ago by " ?><span style="color: #6565f1"><?php echo $fullName?>.</span>
    <?php if (!$modifDate) {
        echo $messageTimeModif;
    } else {
        echo "Modified " . $diffDateModif . " " . $messageTimeModif . " ago";
    } ?>
</p>

<?php foreach ($tableColumn as $column) { ?>
    <!-- ajout condition  -->
<div class="divTable">
    <table>
        <thead>
        <tr>
            <th>
                <?php echo $column->getTitle() ?>
                <?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
                <!-- formulaire pour modifier le title de la colonne -->
                <form action="board/edit_title_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                      method="post">
                    <input type="text" name="newTitleColumn" size="15" placeholder="Enter a new Title">
                    <input type="submit" name="modifTitle" value="Apply">
                </form>
                <form action="column/delete_column/<?php echo $column->getId() ?>" method="post">
                    <input type="submit" name="butonDelColumn" value="&#128465;">
                </form>
                <?php if (count($tableColumn) > 1){ ?>
                <?php if ($column->getPosition() == 0 && count($tableColumn) > 0) { ?>
                    <!-- formulaire déplacement à droite -->
                    <form action="column/move_right_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input type="submit" name="move" value="→">
                    </form>
                <?php } elseif ($column->getPosition() < count($tableColumn) - 1) { ?>
                    <!-- formulaire déplacement à gauche -->
                    <form action="column/move_left_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input type="submit" name="move" value="←">
                    </form>
                    <!-- formulaire déplacement à droite -->
                    <form action="column/move_right_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input type="submit" name="move" value="→">
                    </form>
                <?php } else { ?>
                    <!-- formulaire déplacement à gauche -->
                    <form action="column/move_left_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input type="submit" name="move" value="←">
                    </form>
                <?php } ?>
            </th>
            <?php } ?>
            <?php } ?>
        </tr>
        </thead>
        <?php foreach ($tableCardColumn[$column->getPosition()] as $card) { ?>
            <tbody>
            <tr>
                <td <?php if($dueDate > $card->getDueDate() && $card->getDueDate() != null){ ?> class="RedDueDate" <?php }?>>
                    <!-- formulaire pour ouvrir une carte-->
                    <form action="card/view_card/<?php echo $card->getId() ?>" method="post">
                        <input type="submit" name="openCard" value="<?php echo $card->getTitle() ?>">
                    </form>
                    <?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin" || Participate::check_participate($user,$card)) { ?>
                        <form action="card/delete_card/<?php echo $card->getId() ?>" method="post">
                            <input type="submit" name="deleteCard" value="&#128465;">
                        </form>
                        <?php if ($column->getPosition() == 0) { ?>
                            <!-- formulaire déplacement en haut -->
                            <?php if ($card->getPosition() > 0) { ?>
                                <form action="card/move_up_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input type="submit" name="move" value="↑">
                                </form>
                            <?php } ?>
                            <!-- formulaire déplacement en bas -->
                            <?php if ($card->getPosition() < count($tableCardColumn[$column->getPosition()]) - 1) { ?>
                                <form action="card/move_down_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input type="submit" name="move" value="↓">
                                </form>
                            <?php } ?>
                            <!-- formulaire déplacement en haut -->
                            <?php if (count($tableColumn) > 1) { ?>
                                <form action="card/move_right_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input type="submit" name="move" value="→">
                                </form>
                            <?php } ?>
                            <!-- formulaire déplacement en bas -->
                        <?php } elseif ($column->getPosition() < count($tableColumn) - 1) { ?>
                            <!-- formulaire déplacement en haut -->
                            <?php if ($card->getPosition() > 0) { ?>
                                <form action="card/move_up_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input type="submit" name="move" value="↑">
                                </form>
                            <?php } ?>
                            <!-- formulaire déplacement en bas -->
                            <?php if ($card->getPosition() < count($tableCardColumn[$column->getPosition()]) - 1) { ?>
                                <form action="card/move_down_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input type="submit" name="move" value="↓">
                                </form>
                            <?php } ?>
                            <!-- formulaire déplacement à gauche -->
                            <form action="card/move_left_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                  method="post">
                                <input type="submit" name="move" value="←">
                            </form>
                            <!-- formulaire déplacement à droite -->
                            <form action="card/move_right_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                  method="post">
                                <input type="submit" name="move" value="→">
                            </form>
                        <?php } elseif (count($tableColumn) > 1) { ?>
                            <!-- formulaire déplacement en haut -->
                            <?php if ($card->getPosition() > 0) { ?>
                                <form action="card/move_up_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input type="submit" name="move" value="↑">
                                </form>
                            <?php } ?>
                            <!-- formulaire déplacement en bas -->
                            <?php if ($card->getPosition() < count($tableCardColumn[$column->getPosition()]) - 1) { ?>
                                <form action="card/move_down_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input type="submit" name="move" value="↓">
                                </form>
                            <?php } ?>
                            <!-- formulaire déplacement à gauche -->
                            <form action="card/move_left_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                  method="post">
                                <input type="submit" name="move" value="←">
                            </form>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            </tbody>
        <?php } ?>
        <?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
            <tfoot>
            <tr>
                <!-- formulaire pour ajouter une carte-->
                
                    <td>
                    <form action="board/add_card/<?php echo $column->getBoard()?>/<?php echo $column->getId()?>" method="post">
                        <input type="text" name="titleCard" size="15" placeholder="Add Card">
                        <input class="add" type="submit" name="boutonAddCard" value="+">
                    </form>
                    </td>
                
            </tr>
            </tfoot>
        <?php } ?>
    </table>
    <?php } ?>
    <?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
    <!--formulaire qui s'occupe d'ajouter une colonne au board-->
    <form action="board/add_column/<?php echo $board->getId() ?>" method="post">
        <td>
            <input type="text" name="title" size="15" placeholder="Add a column">
            <input class="add" type="submit" name="boutonAddColumn" value="+">
        </td>
    </form>
    <?php } ?>
</div>
<div id="error">
    <?php if (count($error) > 0) { ?>
        <p>Please check the errors and correct them :</p>
        <ul>
            <?php foreach ($error as $err) { ?>
                <li><?php echo $err ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
</body>
</html>


<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Edit board</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.structure.min.css" rel="stylesheet" type="text/css"/>
    <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="js/conf_del.js" type="text/javascript"></script>
    <script src="lib/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <script src="lib/jquery-validation-1.19.3/dist/jquery.validate.min.js" type="text/javascript"></script>
    <script src="js/validation_title.js" type="text/javascript"></script>
    <script src="js/drag_and_drop.js" type="text/javascript"></script>
</head>
<body>
<?php include("header.php") ?>
<h1>Board "<?php echo $board->getTitle() ?>"</h1>
<?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
    <form action="board/delete_board/<?php echo $board->getId() ?>" method="post">
        <input id="<?php echo $board->getId().'delete_board';?>" type="button" value="Delete Board" hidden>
        <input class="delOrignal" type="submit" name="delBoard" value="Delete Board">
    </form>

    <div id="confirmDialog" title="Delete" hidden>
        <p>do you really want to delete</p>
    </div>
    <?php if (!$viewEditTitleBoard) : ?>
        <form action="board/board/<?php echo $board->getId() ?>" method="post">
            <input type="submit" name="openViewModifTitle" id="openViewModifTitle" value="modify Board">
        </form>
    <?php else: ?>
        <form action="board/edit_title_board/<?php echo $board->getId() ?>" id="modifTitleBoard" method="post">
            <input type="text" name="newTitleBoard" id="newTitleBoard" size="15"  placeholder="Enter a new Title">
            <input type="submit" name="modifTitle" id="modifTitle" value="apply">
            
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
<div class="divTable">
<?php foreach ($tableColumn as $column) { ?>
    <table id="<?php echo $column->getId().'tableColumn';?>" data-id="<?php echo $column->getId()?>" data-position="<?php echo $column->getPosition()?>">
    <thead>
        <tr>
            <th>
                <?php echo $column->getTitle()?><br>
                <?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
                <form action="board/edit_title_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                data-form="<?php echo $column->getPosition()?>" id="<?php echo $column->getPosition().'modifTitleColumn';?>" data-position="<?php echo $column->getPosition()?>"method="post">
                    <input type="text" name="newTitleColumn" data-id="<?php echo $column->getId()?>" id="<?php echo $column->getId() . 'TitleColumnData';?>" size="15" placeholder="Enter a new Title">
                    <input type="submit" name="modifTitle" id="<?php echo $board->getId() ?>" value="Apply">
                </form>
                <form action="column/delete_column/<?php echo $column->getId() ?>" method="post">
                    <input id="<?php echo $column->getId().'delete_column';?>" type="button" value="&#128465;" hidden>
                    <input class="arrowMove" class="delOrignal" type="submit" name="butonDelColumn" value="&#128465;">
                </form>
                <?php if (count($tableColumn) > 1){ ?>
                <?php if ($column->getPosition() == 0 && count($tableColumn) > 0) { ?>
                    <form action="column/move_right_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input class="arrowMove" type="submit" name="move" value="→">
                    </form>
                <?php } elseif ($column->getPosition() < count($tableColumn) - 1) { ?>
                    <form action="column/move_left_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input class="arrowMove" type="submit" name="move" value="←">
                    </form>
                    <form action="column/move_right_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input class="arrowMove" type="submit" name="move" value="→">
                    </form>
                <?php } else { ?>
                    <form action="column/move_left_column/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>"
                          method="post">
                        <input class="arrowMove" type="submit" name="move" value="←">
                    </form>
                <?php } ?>
            </th>
            </thead>
            <?php } ?>
            <?php } ?>
        </tr>
        <tbody class="tbodyTest" data-idColumn="<?php echo $column->getId()?>" id="<?php echo $column->getId().'bodyTable';?>">
        <?php foreach ($tableCardColumn[$column->getPosition()] as $card) { ?>
            <tr data-id="<?php echo $card->getId()?>" data-position="<?php echo $card->getPosition()?>" data-cardIdColumn="<?php echo $card->getColumn()?>">
                <td id="<?php $card->getId();?>"<?php if($dueDate > $card->getDueDate() && $card->getDueDate() != null){ ?> class="RedDueDate" <?php }?>>
                    <form action="card/view_card/<?php echo $card->getId() ?>" method="post">
                        <input type="submit" name="openCard" value="<?php echo $card->getTitle() ?>">
                    </form>
                    <?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin" || Participate::check_participate($user,$card)) { ?>
                        <form action="card/delete_card/<?php echo $card->getId() ?>" method="post">
                            <input id="<?php echo $card->getId().'delete_card';?>" type="button" value="&#128465;" hidden>
                            <input class="delOrignal" type="submit" name="deleteCard" value="&#128465;">
                        </form>
                        <?php if ($column->getPosition() == 0) { ?>
                            <?php if ($card->getPosition() > 0) { ?>
                                <form action="card/move_up_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input class="arrowMove" type="submit" name="move" value="↑">
                                </form>
                            <?php } ?>
                            <?php if ($card->getPosition() < count($tableCardColumn[$column->getPosition()]) - 1) { ?>
                                <form action="card/move_down_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input class="arrowMove" type="submit" name="move" value="↓">
                                </form>
                            <?php } ?>
                            <?php if (count($tableColumn) > 1) { ?>
                                <form action="card/move_right_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input class="arrowMove" type="submit" name="move" value="→">
                                </form>
                            <?php } ?>
                        <?php } elseif ($column->getPosition() < count($tableColumn) - 1) { ?>
                            <?php if ($card->getPosition() > 0) { ?>
                                <form action="card/move_up_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input class="arrowMove" type="submit" name="move" value="↑">
                                </form>
                            <?php } ?>
                            <?php if ($card->getPosition() < count($tableCardColumn[$column->getPosition()]) - 1) { ?>
                                <form action="card/move_down_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input class="arrowMove" type="submit" name="move" value="↓">
                                </form>
                            <?php } ?>
                            <form action="card/move_left_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                  method="post">
                                <input class="arrowMove" type="submit" name="move" value="←">
                            </form>
                            <form action="card/move_right_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                  method="post">
                                <input class="arrowMove" type="submit" name="move" value="→">
                            </form>
                        <?php } elseif (count($tableColumn) > 1) { ?>
                            <?php if ($card->getPosition() > 0) { ?>
                                <form action="card/move_up_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input class="arrowMove" type="submit" name="move" value="↑">
                                </form>
                            <?php } ?>
                            <?php if ($card->getPosition() < count($tableCardColumn[$column->getPosition()]) - 1) { ?>
                                <form action="card/move_down_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                      method="post">
                                    <input class="arrowMove" type="submit" name="move" value="↓">
                                </form>
                            <?php } ?>
                            <form action="card/move_left_card/<?php echo $column->getBoard() ?>/<?php echo $column->getId() ?>/<?php echo $card->getId() ?>"
                                  method="post">
                                <input class="arrowMove" type="submit" name="move" value="←">
                            </form>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            
        <?php } ?>
        </tbody>
        <?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
                <tr>
                <td>
                    <form action="board/add_card/<?php echo $column->getBoard()?>/<?php echo $column->getId()?>" method="post">
                        <input type="text" data-idColumn="<?php echo $column->getId()?>" id="<?php echo $column->getId().'inputAddCard';?>" name="titleCard" size="15" placeholder="Add Card">
                        <input class="add" type="submit" name="boutonAddCard" value="+">
                    </form>
                </td>
                </tr>
        <?php } ?>
    </table>

<?php } ?>
</div>

<h1>Add Column</h1>
<?php if ($board->getOwner() == $user->getId() || User::check_collaborator_board($user,$board) || $user->getRole() == "admin") { ?>
        <form action="board/add_column/<?php echo $board->getId() ?>"  id="newColumn" method="post">
            <input type="text" name="title" id="idtitle" size="15" placeholder="Add a column">
            <input class="add" type="submit" name="boutonAddColumn" id="<?php echo $board->getId() ?>" value="+">
        </form>
<?php } ?>

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


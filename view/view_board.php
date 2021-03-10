<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Boards</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div>
        <?php include("header.php")?>
    </div>
    <h1>Your boards</h1>
    <!-- formulaire qui gère l'affichage et l'ouverture des boards -->
    <?php for($i = 0; $i < count($tableBoard); $i++) { ?>
    <form class="boardForm" action="board/open_Board/<?php echo $tableBoard[$i]->getId() ?>" method="post">
        <tr>
            <td><input id="submitBoardUser" type="submit" name="boutonBoard" size="30" value="<?php echo $tableBoard[$i]->getTitle()." (".$tableNbColumn[$i]."Column)" ?>"></td>
        </tr>
    </form>
    <?php }?>
    <!-- formulaire d'ajout d'un nouveau board -->
    <form class="boardForm" action="board/add_board" method="post">
        <tr>
            <td><input type="text" name="title" size="15" placeholder="add a board">
                <input id="submitBoardUser" type="submit" name="boutonAdd" value="add">
            </td>
        </tr>
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
    </form>
    <h1>Others Boards</h1>
    <!-- formulaire qui affiche la liste des boards != user -->
    <?php for ($i = 0; $i < count($tableOthersBoards); $i++) { ?>
    <form class="boardForm" action="board/open_Board/<?php echo $tableOthersBoards[$i]->getId() ?>" method="post">
        <tr>
            <td><input id="submitBoardAnother" type="submit" name="boutonBoard" size="30" value="<?php echo $tableOthersBoards[$i]->getTitle()." (".$tableNbColumnOther[$i]."Column)" ?>"></td>
        </tr>
    </form>
    <?php } ?>
    <h1>Collaboration Board</h1>
    <?php foreach ($tableBoardCollaboration as $board) {?>
    <form class="boardForm" action="board/open_Board/<?php echo $board->getId() ?>" method="post">
        <tr>
            <td>
            <input id="submitBoardCollabo" type="submit" name="boutonBoard" size="30" value="<?php echo $board->getTitle()?>">
            </td>
        </tr>
    </form>
    <?php }?>
</body>
</html>

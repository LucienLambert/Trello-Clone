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
        <a href="board/logout">Log Out</a>
    </div>
    <h1>Welcome <?php echo $user->fullName ?></h1>

    <h1>Your boards</h1>
    <!-- formulaire qui gère l'affichage et l'ouverture des boards -->
    <?php foreach ($tableBoard as $board) : ?>
    <form class="boardForm" action="board/open_Board/<?php echo $board->id ?>" method="post">
        <tr>
            <td><input type="submit" name="boutonBoard" size="30" value="<?php echo $board->title ?>"></td>
        </tr>
    </form>
    <?php endforeach;?>
    <!-- formulaire d'ajout d'un nouveau board -->
    <form class="boardForm" action="board/add_board" method="post">
        <tr>
            <td><input type="text" name="title" size="15" placeholder="add a board">
                <input type="submit" name="boutonAdd" value="add">
            </td>
        </tr>
        <?php if (count($error) > 0): ?>
            <p>Please check the errors and correct them :</p>
            <ul>
                <?php foreach ($error as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </form>

    <h1>others Boards</h1>
    <!-- formulaire qui affiche la liste des boards != user -->
    <form>
        <tr>
            <?php foreach ($tableOthersBoards as $board) : ?>
                <td><input type="button" name="titleBoard" size="15" id="titleBoard" value="<?php echo $board->title ?>"></td>
            <?php endforeach;?>
        </tr>
    </form>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Boards</title>
    <base href="<?= $web_root ?>"/>
</head>
<body>
    <div>
        <a href="board/logout">Log Out</a>
    </div>
    <h1>Welcome <?php echo $user->fullName ?></h1>
    <h1>Your boards</h1>
    <form id="boardForm" action="board/listBoard" method="post">
        <table>
        <tr>
            <?php foreach ($tableBoard as $board) : ?>
                <td><input type="submit" name="boutonBoard" size="30" value="<?php echo $board->title ?>"></td>
            <?php endforeach;?>
            <td><input type="text" name="title" size="15" placeholder="add a board">
                <input type="submit" name="boutonAdd" value="add">
            </td>
        </tr>
        </table>
        <table>
        <?php if (count($error) > 0): ?>
            <p>Please check the errors and correct them :</p>
            <ul>
                <?php foreach ($error as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <h1>others Boards</h1>
        <tr>
            <?php foreach ($tableOthersBoards as $board) : ?>
                <td><input type="button" name="titleBoard" size="15" id="titleBoard" value="<?php echo $board->title ?>"></td>
            <?php endforeach;?>
        </tr>
        </table>
    </form>
</body>
</html>

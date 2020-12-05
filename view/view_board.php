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
    <form id="addBoardForm" action="board" method="post">
        <tr>
            <td>ajouter les autres board par la suite</td>
            <td><input type="text" id="nameBoard" name="nameBoard" size="30" placeholder="add a board"><input type="submit" name="bouton" value="add"></td>
        </tr>
    </form>
    <h1>Others boards</h1>
</body>
</html>

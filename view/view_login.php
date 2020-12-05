<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trello!</title>
    <base href="<?= $web_root ?>"/>
</head>
<body>
    <div>
        <a href="index">Home</a>
        <a href="user/signup">Sign Up</a>
    </div>
    <h1>Login</h1>
        <form id="loginForm" action="user/login" method="post">
            <table>
            <tr>
                <td>Email :</td>
                <td><input type="email" id="mail" name="mail" size="30" value="<?= $mail ?>" placeholder="Email"></td>
            </tr>
            <tr>
                <td>Password :</td>
                <td><input type="password" id="password" name="password" size="30" value="<?= $password ?>" placeholder="**********"></td>
            </tr>
            </table>
            <input type="submit" name="bouton" value="Login">
        </form>
    <?php if (count($error) > 0): ?>
        <p>Please check the errors and correct them :</p>
        <ul>
            <?php foreach ($error as $err): ?>
                <li><?= $err ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    </body>
</html>

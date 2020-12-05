<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <base href="<?= $web_root ?>"/>
    </head>
    <body>
    <div>
        <a href="index">Home</a>
        <a href="user/login">Login</a>
    </div>
        <h1>Sign Up</h1>
    <form id="signupForm" action="user/signup" method="post">
        <table>
            <tr>
                <td>Email :</td>
                <td><input type="email" name="mail" id="mail" size="30" value="<?php echo $mail?>" placeholder="Email"></td>
            </tr>
            <tr>
                <td>Full Name :</td>
                <td><input type="text" name="fullName" id="fullName" size="30" value="<?php echo $fullName?>" placeholder="Full Name"></td>
            </tr>
            <tr>
                <td>Password :</td>
                <td><input type="password" name="password" id="password" value="<?php echo $password?>" placeholder="Password"></td>
            </tr>
            <tr>
                <td>Confirm your password :</td>
                <td><input type="password" name="conf_password" size="30" value="<?php echo $conf_password?>" placeholder="Confirm your password"></td>
            </tr>
        </table>
        <input type="submit" id="bouton" value="Sign Up">
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


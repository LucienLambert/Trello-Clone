<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Trello!</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="js/login.js" type="text/javascript"></script>
    <script src="lib/jquery-validate.1.19.3.min.js" type="text/javascript"></script>
</head>
<body>
    <?php include("menu.html")?>
    <p></p>
    <h1 class="form-signup">Sign In</h1>
    <main class="form-signup">
        
        <form class="blocktext" id="formLogin" action="user/login" method="post">
            <table>
            <tr>
                <td>@</td>
                <td><input type="email" name="mail" size="30" value="<?= $mail ?>" placeholder="Email" required></td>
            </tr>
            <tr>
                <td>&#x1F512;</td>
                <td><input type="password" name="password" size="30" value="<?= $password ?>" required placeholder="**********"></td>
            </tr>
            </table>
            <input class="submit" type="submit" name="bouton" value="Login">
        </form>
    </main>
    <div class="error">
        <?php if (count($error) > 0) { ?>
            <p>Please check the errors and correct them :</p>
            <?php foreach ($error as $err) { ?>
                <p><?php echo $err ?></p>
            <?php } ?>
        <?php } ?>
    </div>         
    </body>
</html>

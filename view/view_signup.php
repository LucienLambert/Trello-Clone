<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
        <script src="js/signup.js" type="text/javascript"></script>
        <script src="lib/jquery-validation-1.19.3/dist/jquery.validate.min.js" type="text/javascript"></script>
</head>
    <body>
        <?php include("menu.html")?>
    <p></p>
    <h1 class="form-signup">Sign Up</h1>
    <main class="form-signup">
    <form class="blocktext" id="formSignUp" action="user/signup" method="post">
        <table>
            <tr>
                <td>@</td>
                <td><input type="email" id="mail" name="mail" placeholder="Email" value="<?php echo $mail?>"></td>
            </tr>
            <tr>
                <td>&#x1F610;</td>
                <td><input type="text" name="fullName" placeholder="Full Name" value="<?php echo $fullName?>"></td>
            </tr>
            <tr>
                <td>&#x1F512;</td>
                <td><input id="password" type="password" name="password" placeholder="Password"></td>
            </tr>
            <tr>
                <td>&#x1F512;</td>
                <td><input type="password" name="conf_password" placeholder="Confirm your password"></td>
            </tr>
        </table>
        <input class="submit" type="submit" value="Sign Up">
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


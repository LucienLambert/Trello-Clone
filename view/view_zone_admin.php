<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Boards</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>
<div>
    <?php include("header.php") ?>
</div>
<body>
    <h1>List Users</h1>
    <table style="width:100%">
        <tr>
            <th>Fullname (email)</th>
            <th>Role</th>
        </tr>
    <?php foreach($tablUsers as $user): ?>
        <tr>
            <td>
                <?php echo $user->getFullName() . " (" . $user->getMail() . ")"  ?>
            </td>
            <td>
                <form action="user/list_users" method="post">
                    <select name="role">
                        <label>Role :</label></br>
                        <?php if($user->getRole()=="user"):?>
                            <option value="user" selected>User</option>
                            <option value="admin">Admin</option>
                        <?php else: ?>
                            <option value="user">User</option>
                            <option value="admin" selected>Admin</option>
                        <?php endif; ?>    
                    </select>
                    <input type="hidden" name="idUser" value="<?php echo $user->getId() ?>">
                    <input type="submit" value="Update">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</body>
</html>
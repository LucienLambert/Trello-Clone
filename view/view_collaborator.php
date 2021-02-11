<!DOCTYPE>
<html>
<head>
    <head>
        <meta charset="UTF-8">
        <title>Collaborator</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
</head>
<div>
    <?php include("header.php") ?>
</div>
<body>
<br>
<h1>Board"<?php echo $board->getTitle()?>" : Collaborators</h1>
<h4>Current collaborator(s)</h4>
    <ul>
        <?php foreach ($tableCollaborator as $collabo) {?>
        <li><?php echo $collabo->getUser()->getFullName()." (".$collabo->getUser()->getMail().")"?></li>
        <?php }?>
    </ul>
<form action="board/add_collaborators">
    <label>Add a new collaborator:</label><br>
    <select name="collaborator_select">
        <?php foreach ($tableUser as $u) {?>
            <option value="user_collaborator"><?php echo $u->getFullName()." (".$u->getMail().")"?></option>
        <?php }?>
    </select>
    <input type="submit" name="submit_collaborator" value="Add">
</form>
</body>
</html>

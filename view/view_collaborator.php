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
<h1>Board "<?php echo $board->getTitle()?>": Collaborators</h1>
<h4>Current collaborator(s)</h4>
    <ul>
        <?php foreach ($tableCollaborator as $collabo) {?>
        <li>
            <form action="board/del_collaborator/<?php echo $board->getId()?>/<?php echo $collabo->getId()?>" method="post">
                <?php echo $collabo->getUser()->getFullName()." (".$collabo->getUser()->getMail().")"?>
                <input type="submit" name="del" value="Delete">
            </form>
        </li>
        <?php }?>
    </ul>
<form action="board/add_collaborator/<?php echo $board->getId()?>" method="post">
    <label>Add a new collaborator:</label><br>
    <select name="collaborator_select">
        <?php foreach ($tableNotCollabo as $u) {?>
            <option value="<?php echo $u->getId() ?>"><?php echo $u->getFullName()." (".$u->getMail().")"?></option>
        <?php }?>
    </select>
    <input type="submit" name="submit_collaborator" value="Add">
</form>
</body>
</html>

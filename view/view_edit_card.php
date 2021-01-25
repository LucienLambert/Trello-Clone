<!DOCTYPE>
<html>
<head>
    <head>
        <meta charset="UTF-8">
        <title>Edit Card</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
</head>
<body>
<div>
    <p><a href="board/index">Home</a>
        <a href="board/board/<?php echo $board->getId()?>">Board</a>
    </p>
</div>
<h1>Edit a card</h1>
<p>
    <?php echo "Créated " . $diffDate . " " . $messageTime . " ago by " . $fullName . "." ?>
    <?php if (!$modifDate) {
        echo $messageTimeModif;
    } else {
        echo "Modified " . $diffDateModif . " " . $messageTimeModif . " ago";
    } ?>
</p>

<h4>Title</h4>
<form action="card/modif_card/<?php echo $column->getId()?>/<?php echo $card->getId()?>" method="post">
    <input type="text" name="titleCard" value="<?php echo $card->getTitle() ?>">
    <h4>Body</h4>
    <textarea name="bodyCard" rows="10" cols="50"><?php echo $card->getBody() ?></textarea>
    <h4>Board</h4>
    <textarea name="titleboard" disabled="disabled" rows="2" cols="100"><?php echo $board->getTitle()?></textarea>
    <h4>Column</h4>
    <textarea name="titleColumn" disabled="disabled" rows="2" cols="100"><?php echo $column->getTitle()?></textarea></br>
    <input type="submit" name="boutonApply" value="Edit this card">
</form>
<form action="card/modif_card/<?php $column->getId()?>/<?php echo $card->getId()?>" method="post">
    <input type="submit" name="boutonCancel" value="Cancel">
</form>
<?php if (count($error) > 0) { ?>
    <p>Please check the errors and correct them :</p>
    <ul>
        <?php foreach ($error as $err) { ?>
            <li><?php echo $err ?></li>
        <?php } ?>
    </ul>
<?php } ?>
</body>
</html>

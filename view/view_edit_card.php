<!DOCTYPE>
<html lang="en-US">
<head>
    <head>
        <meta charset="UTF-8">
        <title>Edit Card</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
</head>
<body>
<?php include("header.php") ?>
<br/>
<h1>Edit a card</h1>
<p>
    <?php echo "Créated " . $diffDate . " " . $messageTime . " ago by "?><span style="color: #6565f1"><?php echo $authorCard->getFullName()?>.</span>
    <?php if (!$modifDate) {
        echo $messageTimeModif;
    } else {
        echo "Modified " . $diffDateModif . " " . $messageTimeModif . " ago";
    } ?>
</p>

<h3>Title</h3>
<form action="card/modif_card/<?php echo $column->getId()?>/<?php echo $card->getId()?>" method="post">
    <input type="text" name="titleCard" value="<?php echo $card->getTitle() ?>">
    <h3>Body</h3>
    <textarea name="bodyCard" rows="10" cols="50"><?php echo $card->getBody() ?></textarea>
    <h3>Due date : <?php echo $card->getDueDate()?></h3>
        <?php if($card->getDueDate() != null){ ?>
            <a type="button" href="card/del_due_date/<?php echo $card->getId()?>">delete Due Date</a><br>
        <?php } ?>
    <input type="date" name="due_date">
    <h3>Current participant(s) </h3>
    <ul>
        <?php foreach ($tableParticipant as $participant) {?>
        <li style="color: #6565f1">
            <?php echo $participant->getUser()->getFullName()." (".$participant->getUser()->getMail().")"?>
            <a type="button" href="card/del_participant/<?php echo $participant->getIdParticipate() ?>/<?php echo $participant->getIdCard() ?>">Delete</a>
        </li>
        <?php }?>
    </ul>
    <h3>Add a new Participant : </h3>
    
        <select name="participant_select">
            <?php foreach ($tableParticipantValide as $u) {?>
                <option value="<?php echo $u->getId() ?>"><?php echo $u->getFullName()." (".$u->getMail().")"?></option>
            <?php }?>
        </select>
        <input style="background: #6565f1" type="submit" name="submit_participant" value="Add">
    
    <h3>Board</h3>
    <textarea style="background: lightgray" name="titleboard" disabled="disabled" rows="2" cols="100"><?php echo $board->getTitle()?></textarea>
    <h3>Column</h3>
    <textarea style="background: lightgray" name="titleColumn" disabled="disabled" rows="2" cols="100"><?php echo $column->getTitle()?></textarea></br></br>
    <input type="submit" name="boutonApply" value="Edit this card">
</form>
<form action="card/modif_card/<?php $column->getId()?>/<?php echo $card->getId()?>" method="post">
    <input type="submit" name="boutonCancel" value="Cancel">
</form>
<div id="error">
    <?php if (count($error) > 0) { ?>
        <p>Please check the errors and correct them :</p>
        <ul>
            <?php foreach ($error as $err) { ?>
                <li><?php echo $err ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
</body>
</html>

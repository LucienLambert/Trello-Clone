<!DOCTYPE>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>View Card</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/jquery-ui-1.12.1/jquery-ui.structure.min.css" rel="stylesheet" type="text/css"/>
    <script src="lib/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="js/conf_del.js" type="text/javascript"></script>
    <script src="lib/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <script src="lib/jquery-validation-1.19.3/dist/jquery.validate.min.js" type="text/javascript"></script>
</head>

<br/>
<body>
<?php include("header.php") ?>
<h1>Card "<?php echo $card->getTitle() ?>"</h1>
<?php if ($board->getOwner() == $user->getId() || $user->getRole() == "admin" || User::check_collaborator_board($user,$board)) { ?>
    <!-- formulaire pour supprimer la carte -->
    <?php if ($board->getOwner() == $user->getId() || $user->getRole() == "admin" || $card->getAuthor() == $user->getId()) { ?>
    <form class="FormColumn" action="card/delete_card/<?php echo $card->getId()?>" method="post">
        <input id="<?php echo $card->getId().'delete_card';?>" type="button" value="Delete Card" hidden>
        <input class="delOrignal" type="submit" name="delCard" value="Delete Card">
    </form>
    <?php } ?>
    <!-- formulaire pour afficher l'option modifier la carte -->
    <?php if (!$viewEditTitleCard) : ?>
        <form class="FormColumn" action="card/edit_card/<?php echo $card->getId() ?>" method="post">
            <input type="submit" name="openViewModifCard" value="modify Card">
        </form>
    <?php endif; ?>
<?php } ?>
<p>
    <?php echo "Créated " . $diffDate . " " . $messageTime . " ago by "?><span style="color: 6565f1"><?php echo $fullName?>.</span>
    <?php if (!$modifDate) {
        echo $messageTimeModif;
    } else {
        echo "Modified " . $diffDateModif . " " . $messageTimeModif . " ago";
    } ?>
</p>
<p>
    this card is on the board "<span style="color: 6565f1"><?php echo $board->getTitle()?></span>"
    , column "<span style="color: #6565f1"><?php echo $column->getTitle()?></span>" at
    position <?php echo $column->getPosition() ?>;
</p>
<h3>Body</h3>
<textarea style="background: lightgray" name="bodyCard" disabled="disabled" rows="5" cols="100"><?php echo $card->getBody() ?></textarea>
<?php if($card->getDueDate() == null) {?>
    <p>This card has no due date yet</p>
<?php } elseif($currentDate > $card->getDueDate()) { ?>
    <p>this card has expired</p>
<?php } else {?>
    <p>this card will expire on : <?php echo $card->getDueDate();?></p>
<?php }?>
<h4>Current participant(s) :</h4>
<ul>
        <?php foreach ($tableParticipant as $participant) {?>
        <li style="color: #6565f1">
            <form action="board/del_participant/<?php echo $card->getId()?>/<?php echo $participant->getIdParticipate()?>" method="post">
                <?php echo $participant->getUser()->getFullName()." (".$participant->getUser()->getMail().")"?>
            </form>
        </li>
        <?php }?>
    </ul>
</body>
<div id="confirmDialog" title="Delete" hidden>
        <p>do you really want to delete this card " <?php echo $card->getTitle()?>"</p>
</div>
</html>

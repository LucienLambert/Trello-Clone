<!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Card</title>
    <base href="<?= $web_root ?>"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>
<div>
    <?php include("header.php") ?>
</div>
</br>
<body>
<h1>Card "<?php echo $card->getTitle() ?>"</h1>
<?php if ($card->getAuthor() == $user->getID() || $user->getRole() == "admin") { ?>
    <!-- formulaire pour supprimer la carte -->
    <form class="FormColumn" action="card/delete_card/<?php echo $card->getId()?>" method="post">
        <input type="submit" name="delCard" value="Delete Card">
    </form>
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
<?php } else { ?>
    <p>this card will expire on : <?php echo $card->getDueDate();?></p>
<?php } ?>
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
</html>

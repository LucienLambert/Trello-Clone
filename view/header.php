<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
<header>
<div class="header">
    <h1 class="header">Trello!</h1>
    <a class="header" href="board/logout">Log Out</a>
    <a class="header"><?php echo $user->getFullName()?></a>
    <?php if($_GET["action"] == "index"){?>
        <a class="header">Boards</a>
    <?php } ?>
    <?php if($_GET["action"] == "board" || $_GET["action"] == "edit_title_board" || $_GET["action"] == "collaborators"){?>
        <a class="header" href="board/index">Boards</a>
        <a class="header"><?php echo $board->getTitle()?></a>
    <?php } ?>
    <?php if($_GET["action"] == "view_card"){?>
        <a class="header" href="board/index">Boards</a>
        <a class="header" href="board/board/<?php echo $board->getId()?>/board"><?php echo $board->getTitle()?></a>
        <a class="header"><?php echo $card->getTitle()?></a>
    <?php } ?>
    <?php if($_GET["action"] == "edit_card"){?>
        <a class="header" href="board/index">Boards</a>
        <a class="header" href="board/board/<?php echo $board->getId()?>/board"><?php echo $board->getTitle()?></a>
        <a class="header"><?php echo $card->getTitle()?></a>
    <?php } ?>
    <?php if($_GET["action"] == "delete_board" || $_GET["action"] == "delete_column" || $_GET["action"] == "delete_card"){?>
        <a class="header" href="board/index">Boards</a>
    <?php } ?>
</div>
</header>

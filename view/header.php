<header>
<div class="header">
    <h1 class="header">Trello!</h1>
    <a class="header" href="board/logout">Log Out</a>
    <a class="header"><?php echo $user->getFullName()?><?php if($user->getRole() == "admin") { ?><img id="image" src="image/icon_admin.png" alt="admin"><?php }?></a>
    <?php if($user->getRole() == "admin"){ ?>
        <a class="header" href="user/list_users">Manage Users</a>
    <?php } ?>

    <?php if($_GET["action"] == "index" || $_GET["action"] == "open_Board"){?>
        <a class="header" href="calendar/index">Calendar</a>
        <a class="header">Boards</a>
    <?php } ?>
    <?php if($_GET["action"] == "board" || $_GET["action"] == "edit_title_board" || $_GET["action"] == "add_card" || $_GET["action"] == "add_column"){?>
        <a class="header" href="board/index">Boards</a>
        <a class="header"><?php echo $board->getTitle()?></a>
    <?php } ?>
    <?php if($_GET["action"] == "collaborators"){?>
        <a class="header" href="board/index">Boards</a>
        <a class="header" href="board/board/<?php echo $board->getId() ?>"><?php echo $board->getTitle()?></a>
    <?php }?>
    <?php if($_GET["action"] == "view_card"){?>
        <a class="header" href="board/index">Boards</a>
        <a class="header" href="board/board/<?php echo $board->getId()?>/board"><?php echo $board->getTitle()?></a>
        <a class="header"><?php echo $card->getTitle()?></a>
    <?php } ?>
    <?php if($_GET["action"] == "edit_card" || $_GET["action"] == "modif_card"){?>
        <a class="header" href="board/index">Boards</a>
        <a class="header" href="board/board/<?php echo $board->getId()?>/board"><?php echo $board->getTitle()?></a>
        <a class="header"><?php echo $card->getTitle()?></a>
    <?php } ?>
    <?php if($_GET["action"] == "delete_board" || $_GET["action"] == "delete_column" || $_GET["action"] == "delete_card" || $_GET["action"] == "list_users" || $_GET["controller"] == "calendar"){?>
        <a class="header" href="board/index">Boards</a>
    <?php } ?>
</div>
</header>

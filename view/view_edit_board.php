<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit board</title>
        <base href="<?= $web_root ?>"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
        <div>
            <a href="board/index">board</a>
        </div>
    <body>
        <h1>Board "<?php echo $board->title?>"</h1>
        <!-- formulaire pour supprimer le board -->
        <form class="FormColumn" action="board/delete_board" method="post">
            <input type="submit" name="delBoard" value="Delete Board">
        </form>
        <!-- formulaire pour afficher l'option modifier le titre du board -->
        <?php if(!$viewEditTitle) :?>
        <form class="FormColumn" action="board/edit_board/<?php echo $board->title?>" method="post">
            <input type="submit" name="openViewModifTitle" value="modify Board">
        </form>
        <?php else: ?>
        <!-- formulaire pour modifier le titre du board -->
        <form class="FormColumn" action="board/edit_title_board/<?php echo $board->title?>" method="post">
            <input type="text" name="newTitleBoard" size="15" placeholder="Enter a new Title">
            <input type="submit" name="modifTitle" value="apply">
        </form>
        <?php endif; ?>
        <p>
            Créated <?php echo $diffDate ?> <?php echo $messageTime ?>
            ago by <?php echo $fullName ?>
            . <?php echo $modifiedAt ?>
        </p>
        <?php foreach ($tableColumn as $column) : ?>
            <form class="FormColumn">
                <tr>
                    <td><?php echo $column->title ?></td>
                </tr>
            </form>
        <?php endforeach;?>
        <form class="FormColumn" action="board/add_column/<?php echo $board->id?>" method="post">
            <td><input type="text" name="title" size="15" placeholder="Add a column">
            <input type="submit" name="boutonAddColumn" value="Add">
            </td>
            <?php if (count($error) > 0): ?>
                <p>Please check the errors and correct them :</p>
                <ul>
                    <?php foreach ($error as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </form>
    </body>
</html>

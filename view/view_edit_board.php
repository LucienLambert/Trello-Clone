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
        <h1>Board "<?php echo $nameBoard?>"</h1>
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
        <form class="FormColumn" action="board/add_column/<?php echo $nameBoard?>" method="post">
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

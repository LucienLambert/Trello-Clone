<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit board</title>
    <base href="<?= $web_root ?>"/>
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
    <form id="edit_boardForm" action="board/edit_board/<?php echo $nameBoard?>" method="post">
        <table>
            <tr>
                <?php foreach ($tableColumn as $column) : ?>
                    <td><?php echo $column->title ?></td>
                <?php endforeach;?>
                <td><input type="text" name="title" size="15" placeholder="Add a column">
                    <input type="submit" name="boutonAddColumn" value="Add">
                </td>
            </tr>
        </table>
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

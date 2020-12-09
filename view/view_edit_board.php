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
        <?php if(!$viewEditTitleBoard) :?>
        <form class="FormColumn" action="board/edit_board/<?php echo $board->id ?>" method="post">
            <input type="submit" name="openViewModifTitle" value="modify Board">
        </form>
        <?php else: ?>
        <!-- formulaire pour modifier le titre du board -->
        <form class="FormColumn" action="board/edit_title_board/<?php echo $board->id ?>" method="post">
            <input type="text" name="newTitleBoard" size="15" placeholder="Enter a new Title">
            <input type="submit" name="modifTitle" value="apply">
        </form>
        <?php endif; ?>
        <p>
            <?php echo "Créated ".$diffDate." ".$messageTime." ago by ".$fullName."." ?>
            <?php if(!$modifDate){
                echo "Modified ".$messageTimeModif;
            } else {
                echo "Modified ".$diffDateModif." ".$messageTimeModif." ago";
            }?>
        </p>

        <?php foreach ($tableColumn as $column) { ?>
            <!-- ajout condition  -->
            <table style="display:inline" >
                <thead>
                    <tr>
                        <th>
                            <?php echo $column->title ?>
                            <!-- formulaire pour modifier le title de la colonne -->
                            <form action="board/edit_title_column/<?php echo $column->board ?>/<?php echo $column->id ?>" method="post">
                                <input type="text" name="newTitleColumn" size="15" placeholder="Enter a new Title">
                                <input type="submit" name="modifTitle" value="Aplly">
                            </form>
                            <forma action="board/move_column/<?php echo $column->board?>/<?php echo $column->id?>" methode="post">
                                <?php if($column->position == 0) { ?>
                                <input type="submit" name="deplacerColumn<?php $column->id?>>" value="->">
                                <?php } elseif($column->position < count($tableColumn)-1) { ?>
                                    <input type="submit" name="deplacerColumn<?php $column->id?>" value="<-">
                                    <input type="submit" name="deplacerColumn<?php $column->id?>" value="->">
                                <?php } else { ?>
                                    <input type="submit" name="deplacerColumn<?php $column->id?>" value="<-">
                                <?php }?>
                            </forma>
                        </th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                    <td>carte</td>
                </tr>
                <tr>
                    <td>carte</td>
                </tr>
            </tbody>
        </table>
        <?php } ?>

        <form class="FormColumn" action="board/add_column/<?php echo $board->id?>" method="post">
            <td>
                <input type="text" name="title" size="15" placeholder="Add a column">
                <input type="submit" name="boutonAddColumn" value="Add">
            </td>
        </form>
        <?php if (count($error) > 0) { ?>
            <p>Please check the errors and correct them :</p>
            <ul>
                <?php foreach ($error as $err) { ?>
                    <li><?php echo $err ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <!--
        <table>
            <tr>
                <th>Colonne 1</th>
                <th>Colonne 2</th>
            </tr>
            <tr>
                <td>carte colonne 1</td>
                <td>carte colonne 2</td>
            </tr>
            <tr>
                <td>carte colonne 1</td>
                <td>carte colonne 2</td>
            </tr>
        </table>
        -->
    </body>
</html>

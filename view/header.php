<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="header">
    <h1 class="header">Trello!</h1>
    <a class="header" href="board/logout">Log Out</a>
    <a class="header"><?php echo $user->getFullName()?></a>
    <a class="header" href="board/index">Board</a>
</div>
</body>

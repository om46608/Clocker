
<?php
include_once __DIR__ . '/header.php';
require_once __DIR__ . '/models/Admin.php';
//todo dorobic css
?>

<link rel="stylesheet" href="styles/tasks_view.css">
<h1 style="color:white; text-align:center;">Dane użytkowników</h1>
<ul id="tasks-list">
    <li id="start-li">
    <?php
    echo '<input type="text" class="table-head text-input" value="ID" disabled>';
    echo '<input type="text" class="table-head text-input" value="Login" disabled>';
    echo '<input type="text" class="table-head text-input" value="Imię" disabled>';
    echo '<input type="text" class="table-head text-input" value="Nazwisko" disabled>';
    echo '<input type="text" class="table-head text-input" value="E-mail" disabled>';
    echo '<input type="text" class="table-head text-input" value="Hasło" disabled>';
    echo '<input type="text" class="table-head text-input" value="Usuń" disabled>';
    ?>
    </li>
    <?php

    $model = new Admin();
    $data = $model->showAllUsers();
        foreach($data as $rows) {
        echo '<li id="' . $rows->usersId . '">';
        echo '<input type="text" class="table-cell text-input" value="' . $rows->usersId . '" disabled>';
        echo '<input type="text" class="table-cell text-input" value="' . $rows->usersLogin . '" disabled>';
        echo '<input type="text" class="table-cell text-input" value="' . $rows->usersFirstName . '" disabled>';
        echo '<input type="text" class="table-cell text-input" value="' . $rows->usersLastName . '" disabled>';
        echo '<input type="text" class="table-cell text-input" value="' . $rows->usersEmail . '" disabled>';
        echo '<input type="text" class="table-cell text-input" value="' . $rows->usersPassword . '" disabled>';

        echo '<form class="task-remover" action="controllers/Admins.php" method="post">';
        echo '<input type="hidden" name="type" value="delete">';
        echo '<button class="delete-btn btn-hover" type="submit" name="user_delete" value="' . $rows->usersId . '">Usuń</button>';
        echo '</form>';
        
        echo '</li>';
        }
    ?>
</ul>
<?php
include_once __DIR__ .'/footer.php';
?>
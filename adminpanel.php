<?php
    include_once __DIR__ . '/header.php';
?>
<link rel="stylesheet" href="styles/style.css">
<link rel="stylesheet" href="styles/tasks_view.css">
<div class="wrapper">
    <h2> Panel admina </h2>
    <?php
    include_once __DIR__ . '/show_specific_user.php';
    if (isset($_REQUEST['userSearchInput'])) {
        require_once __DIR__ . '/models/Admin.php';
        $model = new Admin();
        $data = $model->showSpecificUser($_REQUEST['userSearchInput']); //todo dodac filtering
        if($data){
            if (isset($data) && count($data)) {
                echo '<li id="start">';
                echo '<input type="text" class="table-head text-input" value="ID" disabled>';
                echo '<input type="text" class="table-head text-input" value="Login" disabled>';
                echo '<input type="text" class="table-head text-input" value="Imię" disabled>';
                echo '<input type="text" class="table-head text-input" value="Nazwisko" disabled>';
                echo '<input type="text" class="table-head text-input" value="E-mail" disabled>';
                echo '<input type="text" class="table-head text-input" value="Hasło" disabled>';
                echo '<input type="text" class="table-head text-input" value="Ustawienia" disabled>';
                echo '</li>';
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
            }
            else {
                echo "Nie znaleziono żadnych wyników.";
            }
        }
        else
        {
            echo "Nie znaleziono żadnych wyników.";
        }
    } ?>
<!-- Pokaz wszystkich userow -->
<?php
    include_once __DIR__ . '/show_users.php';
    include_once __DIR__ . '/logout.php';
?>
<!--Wglad w dane usera -->
</div>
<?php
    include_once  __DIR__ . '/footer.php';
?>
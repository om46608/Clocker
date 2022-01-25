<!--Header-->
<?php
include_once __DIR__ . '/header.php';
include_once __DIR__ . '/helpers/validate_inputs.php';
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/tasks_view.css">
    <title> Clocker </title>
</head>

<body>
<script type="text/javascript" src="scripts/TimeTracker.js"></script>
    <h1 style="color:white; text-align:center;">Taski</h1>
    <form class="forms" method="post" action="controllers/Users.php">
        <input type="hidden" name="type" value="addTask">
        <label>Nazwa zadania
            <input type="text" minlength="3" maxlength="255" placeholder="Tu wpisz nazwę..." name="taskName">
        </label>
        <label>Nazwa projektu
            <input type="text" minlength="3" maxlength="255" placeholder="Tu wpisz nazwę..." name="projectName">
        </label>
        <label>Nazwa klienta
            <input type="text" minlength="3" maxlength="255" placeholder="Tu wpisz nazwę..." name="clientName">
        </label>
        <label>Data rozpoczęcia
            <input type="date" name="startDate">
        </label>
        <?php checkInputs('task') ?>
        <button class='btn btn-hover' type="submit">Dodaj taska!</button>
    </form>
    <ul>
        <li class="filter">
            <input type="text" minlength="3" class="task-filter" placeholder="Filtruj po nazwie projektu..." id="filter">
        </li>

        <ul id="tasks-list">
        <?php
            foreach ($_SESSION['tasks'] as $task)
            {
            echo '<li id="' . $task->task_id . '">';
            echo '<input type="text" id="task_name_input-' . $task->task_id . '" minlength="3" maxlength="255" class="task_name_input text-input" placeholder="Nazwa projektu" value="' . $task->task_name . '" id="name" >';
            echo '<button class="btn-hover" id="start-stop-button" onclick="updateTaskName(' . $task->task_id . ')">&#10003;</button>';
            echo '<input type="text" class="tracker__task__time__new" id="tracker__task__time-' . $task->task_id . '" "class="text-input tracker__task__time-' . $task->task_id . '" value="' . $task->duration . '" disabled>';
            echo '<button class="btn-hover" id="start-stop-button" onclick="startStopTask(' . $task->task_id . ')">Start/Stop</button>';
            echo '<input type="text" class="text-input" value="' . substr($task->end_time, 0, 10) . '" disabled>';
            echo '<input type="text" minlength="3" maxlength="255" class="text-input" placeholder="Nazwa projektu" value="' . $task->project_name . '" disabled>';
            echo '<input type="text" minlength="3" maxlength="255" class="text-input" placeholder="Nazwa klienta" value="' . $task->client_name . '" disabled>';

            echo '<form class="task-remover" method="post" action="controllers/Users.php">';
            echo '<input type="hidden" name="type" value="removeTask">';
            echo '<input type="hidden" name="taskId" value="' . $task->task_id .'">';
            echo '<button class="btn-hover" id="start-stop-button" type="submit">Usuń</button>';
            echo '</form>';


            echo '<form class="task-remover" method="post" action="controllers/Users.php">';
            echo '<input type="hidden" name="type" value="editTask">';
            echo '<input type="hidden" name="taskId" value="' . $task->task_id .'">';
            echo '<button class="btn-hover" id="start-stop-button" type="submit">Edytuj</button>';
            echo '</form>';


            echo '<form id="addTimeToDb-' . $task->task_id . '" class="addTimeToDb" method="post" action="controllers/Users.php">';
            echo '<input type="hidden" name="type" value="addTimeToDb">';
            echo '<input  type="hidden" id="trackedTimeFormInput-' . $task->task_id . '" name="taskTime" value="0">';
            echo '</form>';


            echo '<form id="updateTaskName-' . $task->task_id . '" class="addTimeToDb" method="post" action="controllers/Users.php">';
            echo '<input type="hidden" name="type" value="updateTaskName">';
            echo '<input  type="hidden" id="updateTaskNameFormInput-' . $task->task_id . '" name="updatedTaskName" value="0">';
            echo '</form>';

            echo '</li>';
            }
        ?>
        </ul>
    </ul>
    <ul>
        <li class="sorter" id="sorter">
            <button class="sorter-btn btn btn-hover" id="sorter-name">Sortuj po nazwie</button>
            <button class="sorter-btn btn btn-hover" id="sorter-date">Sortuj po dacie</button>
            <button class="sorter-btn btn btn-hover" id="sorter-type">Sortuj po nazwie klienta</button>
        </li>
    </ul>
    <script src="scripts/Tasks_View.js"></script>
</body>

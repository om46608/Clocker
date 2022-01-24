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
    <h1 style="color:white; text-align:center;">Edytuj task</h1>
    <form class="forms" method="post" action="controllers/Users.php">
        <input type="hidden" name="type" value="updateTask">
        <input type="hidden" name="taskId" value=<?php echo $_SESSION['task_id']?>>
        <label>Nazwa zadania
            <input type="text" minlength="3" maxlength="255" placeholder="Tu wpisz nazwę..." name="taskName" value=<?php echo $_SESSION['task_name']?>>
        </label>
        <label>Nazwa projektu
            <input type="text" minlength="3" maxlength="255" placeholder="Tu wpisz nazwę..." name="projectName" value=<?php echo $_SESSION['project_name']?>>
        </label>
        <label>Nazwa klienta
            <input type="text" minlength="3" maxlength="255" placeholder="Tu wpisz nazwę..." name="clientName" value=<?php echo $_SESSION['client_name']?>>
        </label>
        <label>Data rozpoczęcia
            <input type="date" name="startDate" value=<?php echo $_SESSION['end_time']?>>
        </label>
        <?php checkInputs('task') ?>
        <button class="btn btn-hover" type="submit">Zaktualizuj taska!</button>
    </form>
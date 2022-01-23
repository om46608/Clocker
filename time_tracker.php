<script type="text/javascript" src="scripts/TimeTracker.js"></script>
<link rel="stylesheet" type="text/css" href="styles/time_tracker.css" />
<link rel="stylesheet" href="style.css"/>
<?php
include_once __DIR__ .'/header.php';
?>

<div class="tracker-wrapper">
    <div class="tracker">
        <div class="tracker__task">
            <div class="tracker__task__name">
                <input class="tracker__task__name__input" type="text" placeholder="Nazwa taska">
            </div>
            <div class="tracker__task__control">
                <button id = "start-stop-btn" onclick="startStopTask()">START / STOP</button>
            </div>
            <div class="tracker__task__time">
                00:00
            </div>
        </div>
        <div class="tracker__past">
            <div class="tracker__past__header">
                <h2>Wcześniejsze pomiary:</h2>
            </div>
        </div>
        <div class="tracker__history">
        </div>
    </div>
</div>

<div class="tracker-error-wrapper">
    <div class="tracker-error">
        <h2>Błąd!</h2>
        <p class="tracker-error__content">

        </p>
        <button onclick="closeErrorModal()">Zamknij</button>
    </div>
</div>


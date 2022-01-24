<?php
require_once './libraries/Database.php';
require_once './models/User.php';
require_once './models/Task.php';
$user = new User();
$tasks = new Task();

$count_all = $user->countAllUsers();
$count_all = json_decode(json_encode($count_all), true);
$count_all = (array_shift($count_all[0]));

$count_time = $tasks->getSumOfTaskTimes();
$count_time = json_decode(json_encode($count_time), true);
$count_time = (array_shift($count_time[0]));

?>
<h2 id = "stats-for-everyone"> Mamy <b> <?php echo $count_time?> </b> zarejestrowanych godzin!  </h2>
<h3 id = "stats-for-everyone"> Mamy <b> <?php echo $count_all?> </b> zarejestrowanych użytkowników!  </h3>

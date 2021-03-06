<?php
require_once __DIR__ . '/../libraries/Database.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/User.php';

class Task
{
    private $database;


    public function __construct()
    {
        $this->database = new Database;
    }

    public function getTasks()
    {
        $this->database->query('SELECT * FROM tasks');
        $this->database->execute();
        return $this->database->getAllResults();
    }

    public function checkIfTaskExists($taskName, $projectName)
    {
        
        $this->database->query('SELECT * FROM tasks WHERE task_name = :taskName OR project_name = :projectName');
        $this->database->bind(':taskName', $taskName);
        $this->database->bind(':projectName', $projectName);

        $row = $this->database->getOneResult();
        if ($this->database->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
        
    }
    public function addTask($task_fields)
    {
        $this->database->query('INSERT INTO tasks (task_name, start_time, end_time, usersId, project_name, duration, client_name) 
        VALUES (:taskName, :startTime, :endTime, :usersId, :projectName, :duration, :clientName)');
        $this->database->bind(':taskName', $task_fields[0]);
        $this->database->bind(':startTime', $task_fields[3]);
        $this->database->bind(':endTime', $task_fields[3]);
        $this->database->bind(':usersId', $_SESSION['usersId']);
        $this->database->bind(':projectName', $task_fields[1]);
        $this->database->bind(':duration', "00:00:00");
        $this->database->bind(":clientName", $task_fields[2]);

        if ($this->database->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function removeTask($taskId)
    {
        $this->database->query('DELETE FROM tasks WHERE task_id = :taskId');
        $this->database->bind(':taskId', $taskId);
        if ($this->database->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function addTimeToTask($taskId, $taskTime) {
        $this->database->query('UPDATE tasks SET duration = :taskTime WHERE task_id = :taskId');
        $this->database->bind(':taskTime', $taskTime);
        $this->database->bind(':taskId', $taskId);
        if ($this->database->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTask($taskId)
    {
        $this->database->query('SELECT * FROM tasks WHERE task_id = :taskId');
        $this->database->bind(':taskId', $taskId);
        $row = $this->database->getOneResult();
        if ($this->database->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
    public function updateTaskName($taskId, $taskName) {
        $this->database->query('UPDATE tasks SET task_name = :taskName WHERE task_id = :taskId');
        $this->database->bind(':taskName', $taskName);
        $this->database->bind(':taskId', $taskId);
        if ($this->database->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTask($task_fields){
        $this->database->query('UPDATE tasks SET task_name=:taskName, start_time=:startTime, end_time=:endTime, usersId=:usersId, 
        project_name=:projectName, client_name=:clientName WHERE task_id=:taskId');
        $this->database->bind(':taskName', $task_fields[1]);
        $this->database->bind(':startTime', $task_fields[4]);
        $this->database->bind(':endTime', $task_fields[4]);
        $this->database->bind(':usersId', $task_fields[5]);
        $this->database->bind(':projectName', $task_fields[2]);
        $this->database->bind(":clientName", $task_fields[3]);
        $this->database->bind(":taskId", $task_fields[0]);

        if ($this->database->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getSumOfTaskTimes(){
        $this->database->query('SELECT (SUM(TIME_TO_SEC(duration))) FROM tasks;');
        $this->database->execute();
        return $this->database->getAllResults();
    }
}
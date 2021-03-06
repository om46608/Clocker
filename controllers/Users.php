<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/validate_inputs.php';

class Users
{
    private $users_first_name;
    private $users_last_name;
    private $users_login;
    private $users_email;
    private $users_password;
    private $users_password_repeat;
    private $firstLoadComplete = false;

    /**
     * @return mixed
     */
    public function getUsersPasswordRepeat()
    {
        return $this->users_password_repeat;
    }

    /**
     * @param mixed $users_password_repeat
     */
    public function setUsersPasswordRepeat($users_password_repeat): void
    {
        $this->users_password_repeat = $users_password_repeat;
    }

    public function __construct()
    {
        $this->user = new User();
        $this->task = new Task();
    }

    /**
     * @return mixed
     */
    public function getUsersFirstName()
    {
        return $this->users_first_name;
    }

    /**
     * @param mixed $users_first_name
     */
    public function setUsersFirstName($users_first_name): void
    {
        $this->users_first_name = $users_first_name;
    }

    /**
     * @return mixed
     */
    public function getUsersLastName()
    {
        return $this->users_last_name;
    }

    /**
     * @param mixed $users_last_name
     */
    public function setUsersLastName($users_last_name): void
    {
        $this->users_last_name = $users_last_name;
    }

    /**
     * @return mixed
     */
    public function getUsersLogin()
    {
        return $this->users_login;
    }

    /**
     * @param mixed $users_login
     */
    public function setUsersLogin($users_login): void
    {
        $this->users_login = $users_login;
    }

    /**
     * @return mixed
     */
    public function getUsersEmail()
    {
        return $this->users_email;
    }

    /**
     * @param mixed $users_email
     */
    public function setUsersEmail($users_email): void
    {
        $this->users_email = $users_email;
    }

    /**
     * @return mixed
     */
    public function getUsersPassword()
    {
        return $this->users_password;
    }

    /**
     * @param mixed $users_password
     */
    public function setUsersPassword($users_password): void
    {
        $this->users_password = $users_password;
    }


    public function register()
    {
        $userdata = new Users();
        $userdata->setUsersFirstName($_POST['usersFirstName']);
        $userdata->setUsersLastName($_POST['usersLastName']);
        $userdata->setUsersLogin($_POST['usersLogin']);
        $userdata->setUsersEmail($_POST['usersEmail']);
        $userdata->setUsersPassword($_POST['usersPassword']);
        $userdata->setUsersPasswordRepeat($_POST['repeatUsersPassword']);
        //TODO Mozna dodac funkcje ktora by usuwa??a przypadkowe spacje

        //Sprawdzanie czy kt??re?? z p??l jest puste
        $user_fields = [
            $userdata->getUsersFirstName(),
            $userdata->getUsersLastName(),
            $userdata->getUsersLogin(),
            $userdata->getUsersEmail(),
            $userdata->getUsersPassword(),
            $userdata->getUsersPasswordRepeat()
        ];

        foreach ($user_fields as $key => $item) {
            if (empty($user_fields[$key])) {
                checkInputs("register", "Wszystkie dane musz?? by?? wype??nione");
                $newURL = '../index.php?action=register';
                header('Location: ' . $newURL);
                exit();
            }

        }

        if (preg_match('~[0-9]+~', $userdata->getUsersFirstName())) {
            checkInputs("register", "Wprowadzono nieprawid??owe imi?? - imi?? mo??e zawiera?? tylko litery");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();
        }

        if (preg_match('~[0-9]+~', $userdata->getUsersLastName())) {
            checkInputs("register", "Wprowadzono nieprawid??owe nazwisko - imi?? mo??e zawiera?? tylko litery");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();
        }

        //Sprawdzanie czy login zawiera tylko litery i cyfry oraz czy jest d??u??szy ni?? 3 znaki
        if (strlen($userdata->getUsersLogin()) <= 3) {
            checkInputs("register", "Login u??ytkownika nie mo??e by?? kr??tszy ni?? 3 znaki");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();

        } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $userdata->getUsersLogin())) {
            checkInputs("register", "Login mo??e zawiera?? tylko litery i cyfry");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();
        }

        //Sprawdzanie czy has??o ma minimum TYMCZASOWO 3 znaki TODO 8
        if (strlen($userdata->getUsersPassword()) <= 7) {
            checkInputs("register", "Has??o musi mie?? 8 lub wi??cej znak??w");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();
        }

        //Weryfikacja adresu email
        if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/", $userdata->getUsersEmail())) {
            checkInputs("register", "Wprowadzono niepoprawny adres e-mail");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();
        }


        //Sprawdzanie czy powt??rzone has??o jest takie same
        $check_password = strval($userdata->getUsersPasswordRepeat());
        if (!preg_match("/^" . $check_password . "$/", $userdata->getUsersPassword())) {
            checkInputs("register", "Has??a nie s?? zgodne");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();
        }

        //Sprawdzanie czy user juz istnieje
        if ($this->user->checkIfUserExists($userdata->getUsersLogin(), $userdata->getUsersEmail())) {
            checkInputs("register", "Taki u??ytkownik ju?? istnieje");
            $newURL = '../index.php?action=register';
            header('Location: ' . $newURL);
            exit();
        }

        //Haszowanie has??a
        //https://www.php.net/manual/en/function.password-hash.php
        $userpasswd = $userdata->getUsersPassword();
        $userdata->setUsersPassword(password_hash($userpasswd, PASSWORD_DEFAULT));

        //Rejestracja usera
        if ($this->user->register($userdata)) {
            $newURL = '../homepage.php';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }

    public function update()
    {
        $userdata = new Users();
        $userdata->setUsersFirstName($_POST['usersFirstName']);
        $userdata->setUsersLastName($_POST['usersLastName']);
        $userdata->setUsersLogin($_POST['usersLogin']);
        $userdata->setUsersEmail($_POST['usersEmail']);
        $userdata->setUsersPassword($_POST['usersPassword']);
        $userdata->setUsersPasswordRepeat($_POST['repeatUsersPassword']);
        //Mozna dodac funkcje ktora by usuwa??a przypadkowe spacje

        $wdf = 0; //flaga na b????dy

        //Sprawdzanie czy kt??re?? z p??l jest puste
        $user_fields = [
            $userdata->getUsersFirstName(),
            $userdata->getUsersLastName(),
            $userdata->getUsersLogin(),
            $userdata->getUsersEmail(),
            $userdata->getUsersPassword(),
            $userdata->getUsersPasswordRepeat()
        ];

        foreach ($user_fields as $key => $item) {
            if (empty($user_fields[$key])) {
                checkInputs("update", "Wszystkie dane musz?? by?? wype??nione");
                $newURL = '../profile.php';
                header('Location: ' . $newURL);
                exit();
            }

        }

        if (preg_match('~[0-9]+~', $userdata->getUsersFirstName())) {
            checkInputs("update", "Wprowadzono nieprawid??owe imi?? - imi?? mo??e zawiera?? tylko litery");
            $newURL = '../profile.php';
            header('Location: ' . $newURL);
            exit();
        }

        if (preg_match('~[0-9]+~', $userdata->getUsersLastName())) {
            checkInputs("update", "Wprowadzono nieprawid??owe nazwisko - imi?? mo??e zawiera?? tylko litery");
            $newURL = '../profile.php';
            header('Location: ' . $newURL);
            exit();
        }

        //Sprawdzanie czy login zawiera tylko litery i cyfry oraz czy jest d??u??szy ni?? 3 znaki
        if (strlen($userdata->getUsersLogin()) <= 3) {
            checkInputs("update", "Login u??ytkownika nie mo??e by?? kr??tszy ni?? 3 znaki");
            $newURL = '../profile.php';
            header('Location: ' . $newURL);
            exit();

        } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $userdata->getUsersLogin())) {
            checkInputs("update", "Login mo??e zawiera?? tylko litery i cyfry");
            $newURL = '../profile.php';
            header('Location: ' . $newURL);
            exit();
        }

        //Sprawdzanie czy has??o ma minimum TYMCZASOWO 3 znaki TODO 8
        if (strlen($userdata->getUsersPassword()) <= 7) {
            checkInputs("update", "Has??o musi mie?? 8 lub wi??cej znak??w");
            $newURL = '../profile.php';
            header('Location: ' . $newURL);
            exit();
        }

        //Weryfikacja adresu email
        if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/", $userdata->getUsersEmail())) {
            checkInputs("update", "Wprowadzono niepoprawny adres e-mail");
            $newURL = '../profile.php';
            header('Location: ' . $newURL);
            exit();
        }


        //Sprawdzanie czy powt??rzone has??o jest takie same
        $check_password = strval($userdata->getUsersPasswordRepeat());
        if (!preg_match("/^" . $check_password . "$/", $userdata->getUsersPassword())) {
            checkInputs("update", "Has??a nie s?? zgodne");
            $newURL = '../profile.php';
            header('Location: ' . $newURL);
            exit();
        }

        //Haszowanie has??a
        //https://www.php.net/manual/en/function.password-hash.php
        $userpasswd = $userdata->getUsersPassword();
        $userdata->setUsersPassword(password_hash($userpasswd, PASSWORD_DEFAULT));

        //Aktualizacja usera
        if ($this->user->update($userdata, $_SESSION['usersId'])) {
            $_SESSION['usersLogin'] = $userdata->getUsersLogin();
            $newURL = '../index.php';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }

    public function login()
    {
        $user = new Users();
        $user->setUsersLogin($_POST['usersLogin']);
        $user->setUsersPassword($_POST['usersPassword']);


        $user_fields = [
            $user->getUsersLogin(),
            $user->getUsersPassword(),
        ];

        foreach ($user_fields as $key => $item) {
            if (empty($user_fields[$key])) {
                checkInputs("login", "Wszystkie dane musz?? by?? wype??nione");
                $newURL = '../index.php?action=login';
                header('Location: ' . $newURL);
                exit();
            }
        }

        //Sprawdzanie czy user istnieje
        if ($this->user->checkIfUserExists($user->getUsersLogin(), $user->getUsersPassword())) {
            echo "U??ytkownik istnieje\n";
            $logged = $this->user->login($user->getUsersLogin(), $user->getUsersPassword());

            if ($logged) {
                $_SESSION['tasks'] = $this->task->getTasks();
                echo $_SESSION['tasks'];
                $this->newSession($logged);
            } else {
                checkInputs("login", "Podano z??e has??o");
                $newURL = '../index.php?action=login';
                header('Location: ' . $newURL);
                exit();
            }
        } //Je??li u??ytkownika nie znaleziono...
        else {
            checkInputs("login", "Nie ma takiego u??ytkownika");
            $newURL = '../index.php?action=login';
            header('Location: ' . $newURL);
            exit();
        }
    }

    public function newSession($user)
    {
        $session_attrs = array(
            'usersId',
            'usersLogin',
            'usersFirstName',
            'usersLastName',
            'usersEmail'
        );
        foreach ($session_attrs as $value) {
            $_SESSION[$value] = $user->$value;
        }
        $newURL =  '../index.php';
        header('Location: ' . $newURL);
        echo __DIR__;
    }

    public function deleteUser($user_id)
    {
        $this->user->deleteUser($user_id);
    }

    public function destroySession()
    {
        $session_attrs = array(
            'usersId',
            'usersLogin',
            'usersEmail'
        );
        foreach ($session_attrs as $value) {
            unset($_SESSION[$value]);
        }
        session_destroy();
        $newURL = '../index.php';
        header('Location: ' . $newURL);
    }

    public function editUser()
    {
        $temp = $this->user->getUserData($_SESSION['usersId']);
        $get_attrs = array(
            'usersId',
            'usersLogin',
            'usersFirstName',
            'usersLastName',
            'usersEmail'
        );
        foreach ($get_attrs as $attr)
        {
            $_SESSION[$attr] = $temp->$attr;
        }

        $newURL = '../index.php?action=profile';
        header('Location: ' . $newURL);
    }

    public function getTasks()
    {
        $_SESSION['tasks'] = $this->task->getTasks();
        echo $_SESSION['tasks'];
        $newURL = '../index.php?action=tasks';
        header('Location: ' . $newURL);
    }

    public function addTask() {
        //echo '<input type="text" minlength="3" maxlength="7" class="text-input" placeholder="Nazwa projektu" value="' . $task->project_name . '" disabled>';
        $task_fields = [
            $_POST['taskName'], //0
            $_POST['projectName'], //1
            $_POST['clientName'], //2
            $_POST['startDate'], //3
            $_POST['startDate'], //4
            $_SESSION['usersId'] //5
        ];
        foreach ($task_fields as $key => $item) {
            if (empty($task_fields[$key])) {
                checkInputs("task", "Wszystkie dane musz?? by?? wype??nione");
                $newURL = '../index.php?action=tasks';
                header('Location: ' . $newURL);
                exit();
            }
        }
        if ($this->task->checkIfTaskExists($task_fields[0], $task_fields[1])) {
            checkInputs("task", "Taki task ju?? istnieje");
            $newURL = '../index.php?action=tasks';
            header('Location: ' . $newURL);
            exit();
        }
        if ($this->task->addTask($task_fields)) {
            $_SESSION['tasks'] = $this->task->getTasks();
            echo $_SESSION['tasks'];
            $newURL = '../index.php?action=tasks';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }

    public function removeTask()
    {
        if ($this->task->removeTask($_POST["taskId"])) {
            $_SESSION['tasks'] = $this->task->getTasks();
            echo $_SESSION['tasks'];
            $newURL = '../index.php?action=tasks';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }

    public function addTimeToTask() {
        $id = explode(":::", strval($_POST["taskTime"]))[0];
        $timee = explode(":::", strval($_POST["taskTime"]))[1];

        if ($this->task->addTimeToTask($id, $timee)) {
            $_SESSION['tasks'] = $this->task->getTasks();
            echo $_SESSION['tasks'];
            $newURL = '../index.php?action=tasks';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }

    public function updateTaskName() {
        $id = explode(":::", strval($_POST["updatedTaskName"]))[0];
        $task_new_name = explode(":::", strval($_POST["updatedTaskName"]))[1];

        if ($this->task->updateTaskName($id, $task_new_name)) {
            $_SESSION['tasks'] = $this->task->getTasks();
            echo $_SESSION['tasks'];
            $newURL = '../index.php?action=tasks';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }

    public function editTask()
    {
        $temp = $this->task->getTask($_POST['taskId']);
        $get_attrs = array(
            'task_id',
            'task_name',
            'end_time',
            'project_name',
            'client_name'
        );
        foreach ($get_attrs as $attr)
        {
            $_SESSION[$attr] = $temp->$attr;
        }

        $newURL = '../index.php?action=edit_task';
        header('Location: ' . $newURL);
    }

    public function updateTask() {
        //echo '<input type="text" minlength="3" maxlength="7" class="text-input" placeholder="Nazwa projektu" value="' . $task->project_name . '" disabled>';
        $task_fields = [
            $_POST['taskId'],//0
            $_POST['taskName'], //1
            $_POST['projectName'], //2
            $_POST['clientName'], //3
            $_POST['startDate'], //4
            $_POST['startDate'], //5
            $_SESSION['usersId'] //6
        ];
        foreach ($task_fields as $key => $item) {
            if (empty($task_fields[$key])) {
                checkInputs("task", "Wszystkie dane musz?? by?? wype??nione. Brakuje " . $key);
                $newURL = '../index.php?action=tasks';
                header('Location: ' . $newURL);
                exit();
            }
        }
        if ($this->task->updateTask($task_fields)) {
            $_SESSION['tasks'] = $this->task->getTasks();
            echo $_SESSION['tasks'];
            $newURL = '../index.php?action=tasks';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }
    public function download_csv(){
        $userId = $_SESSION['usersId'];
        $result=$this->user->getCsvData($userId);

        $filename = 'raport.csv';
        $fp=fopen('php://output','w');
        //ob_clean();
        $headers=array(
            "TaskId",
            "TaskName",
            "StartTime",
            "EndTime",
            "ProjectName",
            "Duration",
            "ClientName"
        );
        header("Content-Description: File Transfer");
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        $delimiter = ",";

        fputcsv($fp,$headers,$delimiter);

        foreach ($result as $row){
            $content = array($row->task_id,$row->task_name,$row->start_time,$row->end_time,$row->project_name,$row->duration,$row->client_name);

            fputcsv($fp,$content,$delimiter);
        }


        fclose($fp);

        exit;
    }
}

$user = new Users();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'register')
        $user->register();
    if ($_POST['type'] == 'login')
        $user->login();
    if ($_POST['type'] == 'update')
        $user->update();
    if ($_POST['type'] == 'deleteMe') {
        $user->deleteUser($_SESSION['usersId']);
        $user->destroySession();
    }
    if ($_POST['type'] == 'editUser')
        $user->editUser($user);
    if ($_POST['type'] == 'addTask')
        $user->addTask();
    if ($_POST['type'] == 'removeTask')
        $user->removeTask();
    if ($_POST['type'] == 'addTimeToDb')
        $user->addTimeToTask();
    if ($_POST['type'] == 'updateTaskName')
        $user->updateTaskName();
    if ($_POST['type'] == 'editTask')
        $user->editTask();
    if ($_POST['type'] == 'updateTask')
        $user->updateTask();
    if ($_POST['type']=='dwn_csv'){
        $user->download_csv();
    }
}

if (isset($_SESSION['usersId'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($_GET['type'] == 'logout') {
            $user->destroySession();
        }
        if ($_GET['type'] == 'getTasks') {
            $user->getTasks();
        }
    }
}
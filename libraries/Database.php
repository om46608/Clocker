<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'clocker';
    private $dbuser = 'root';
    private $dbpass = 'rafiki';

    private $dbh;
    private $stmt;
    private $err;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        //pdo...
        try {
            $this->dbh = new PDO($dsn,
                $this->dbuser,
                $this->dbpass,
                $options);
        } catch (PDOException $e) {
            $this->err = $e->getMessage();
            echo $this->err;
        }
    }

    //https://www.php.net/manual/en/pdo.prepare.php
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    //https://www.php.net/manual/en/pdostatement.bindvalue.php
    public function bind($param, $value, $type = PDO::PARAM_STR)
    {
        //type ustawiony na stringa, w razie potrzeby należy zmienić w parametrach na null i ifami czy jakkolwiek sprwadzić jaki jest typ wartosci
        $this->stmt->bindValue($param, $value, $type);
    }

    //https://www.php.net/manual/en/pdostatement.execute.php
    public function execute()
    {
        return $this->stmt->execute();
    }

    //https://www.php.net/manual/en/pdostatement.rowcount.php
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    //https://www.php.net/manual/en/pdostatement.fetch.php
    public function getOneResult()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //https://www.php.net/manual/en/pdostatement.fetchall.php
    public function getAllResults()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

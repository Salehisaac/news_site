<?php

    namespace DataBase;
    use PDO;
    use PDOException;

    class DataBase{

        private $connection;
        private $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        private $dbHost = DB_HOST;
        private $dbName = DB_NAME;
        private $dbUserName = DB_USERNAME;
        private $dbPassword = DB_PASSWORD;

        public function __construct()
        {
            try{
                $this->connection = new PDO("mysql:host=" . $this->dbHost. ";dbname=" . $this->dbName , $this->dbUserName, $this->dbPassword, $this->options);

            }catch(PDOException $e){
                    echo $e->getMessage();
                exit();
            }
        }

        public function select($sql, $values = null)
        {

            try
            {
                $stmt = $this->connection->prepare($sql);
                if($values == null)
                {
                    $stmt->execute();
                }
                else
                {
                    $stmt->execute($values);
                }
                return $stmt;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
                exit();
                return false ;
            }
        }

        public function insert($tableName, $fields, $values)
        {
            try
            {

                $stmt = $this->connection->prepare("INSERT INTO ".$tableName."(". implode(', ', $fields) . " , created_at) VALUES ( :" . implode(', :', $fields) . ", NOW());");
                $stmt->execute(array_combine($fields, $values));
                return true;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
                return false;
            }
        }

    }
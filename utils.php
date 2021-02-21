<?php

namespace VisitorApp;

class App {
    private $connection;
    private $visitor_hash;

    public function __construct($connection, $visitor_hash)
    {
        $this->connection = $connection;
        $this->visitor_hash = $visitor_hash;
    }

    function checkQuery(){
        if (mysqli_errno($this->connection)){
            die('Query failed: ' . mysqli_error($this->connection));
        }
    }

    function createTable(){
        $sql = <<<EOT
CREATE TABLE IF NOT EXISTS `visitors`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `hash` VARCHAR(32) NOT NULL,
    `visited_at` TIMESTAMP,
    `visits` INT DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
EOT;
        mysqli_query($this->connection, $sql);
        $this->checkQuery();
    }

    function setupDatabase(){
        $this->createTable();
    }

    /** Checks visitor on existence in DB */
    function visitorExists(){
        $sql = "SELECT * FROM visitors WHERE hash='$this->visitor_hash' and DATE(visited_at)=CURDATE()";
        $result = mysqli_query($this->connection, $sql);
        $this->checkQuery();
        if ($result){
            return mysqli_num_rows($result) > 0;
        }
    }

    /** Adds visitor regarding provided hash*/
    function addVisitor(){
        $request_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        $sql = "INSERT INTO visitors(hash, visited_at) VALUES('$this->visitor_hash', '$request_time')";
        $result = mysqli_query($this->connection, $sql);
        $this->checkQuery();
        return $result;
    }

    /** Increments visits count by one */
    function incrementVisitCount(){
        $request_time = $_SERVER['REQUEST_TIME'];
        $sql = "UPDATE visitors SET visits=visits + 1 WHERE hash='{$this->visitor_hash}'";
        $result = mysqli_query($this->connection, $sql);
        $this->checkQuery();
        return $result;
    }

    function getAll($when=null){
        $date = $when ?? date('Y-m-d');
        $sql = "SELECT hash, visited_at, visits FROM visitors WHERE DATE(visited_at)='$date'";
        $result = mysqli_query($this->connection, $sql);
        $this->checkQuery();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }
}

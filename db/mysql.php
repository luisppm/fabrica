<?php

class bd_mysql {

    private $servidor = "localhost";
    private $nomedb = "fabrica";
    private $user = "root";
    private $senha = "";
    private $bd = "";

    function conectar_mysql() {
        $db = mysqli_connect('localhost', 'root', '') or trigger_error(mysql_error());

        mysqli_select_db($db, 'fabrica') or trigger_error(mysql_error());

        date_default_timezone_set("America/Sao_Paulo");

        return $db;
    }

    function getDB() {
        return $this->nomedb;
    }

    function getServidor() {
        return $this->servidor;
    }

}

// Tenta se conectar ao servidor MySQL
//$db = mysqli_connect('localhost', 'root', '') or trigger_error(mysql_error());
//mysql_connect('localhost', 'root', '') or trigger_error(mysql_error());
// Tenta se conectar a um banco de dados MySQL
//$con = mysqli_select_db($db, 'fabrica') or trigger_error(mysql_error());


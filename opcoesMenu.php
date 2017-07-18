<?php

require_once './db/mysql.php';

$bd_mysql = new bd_mysql();
$conn_mysql = $bd_mysql->conectar_mysql();

if ($_POST['id']) {
    $return = '';
    $sqlNivel = "SELECT menu.nivel FROM menu WHERE status NOT LIKE 'I' GROUP BY menu.nivel ORDER BY menu.nivel ASC";
    echo "$sqlNivel<br>";
    $queryNivel = mysqli_query($conn_mysql, $sqlNivel);
    while($registroNivel = mysqli_fetch_array($queryNivel)){
        $sql
        $return.= $registroNivel['nivel'].'<br>';
    }
    echo $return;
}


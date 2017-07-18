<?php

require_once './db/mysql.php';

$bd_mysql = new bd_mysql();
$conn_mysql = $bd_mysql->conectar_mysql();

if ($_POST['acao'] == "salvar") {
        if ($_POST['id']) {
        $UPDATE = "UPDATE usuarios SET descricao='" . $_POST['descricao'] . "', link='" . $_POST['link'] . "', nivel='" . $_POST['nivel'] . "', id_pai='" . ($_POST['id_pai'] ? $_POST['id_pai'] : 0) . "', status='" . $_POST['status'] . "' WHERE id=" . $_POST['id'];
        echo "$UPDATE";
        if (mysqli_query($conn_mysql, $UPDATE)) {
            echo "1";
        } else {
            echo "0";
        }
    } else {
        $insert = "INSERT INTO menu (descricao, link, nivel, id_pai, status) VALUES ('" . $_POST['descricao'] . "', '" . $_POST['link'] . "', " . $_POST['nivel'] . ", " . ($_POST['id_pai'] ? $_POST['id_pai'] : 0) . ", '" . $_POST['status'] . "')";
        if (mysqli_query($conn_mysql, $insert)) {
            echo '1';
        } else {
            echo '0';
        }
    }
}

if ($_POST['acao'] == "excluir") {
    $delete = "DELETE FROM menu WHERE id=" . $_POST['id'];
    if (mysqli_query($conn_mysql, $delete)) {
        echo '1';
    } else {
        echo '0';
    }
}
if ($_POST['acao'] == "editar") {
    $sql = "SELECT * FROM usuarios WHERE id=" . $_POST['id'];
    $query = mysqli_query($conn_mysql, $sql);


    while ($registro = mysqli_fetch_array($query)) {
        $return = array('id' => $registro['id'], 'nome' => $registro['nome'], 'usuario' => $registro['usuario'], 'email' => $registro['email'], 'ativo' => $registro['ativo'], 'idsetor' => $registro['idsetor'], 'idgrupo' => $registro['idgrupo']);
    }
    echo json_encode($return);
}






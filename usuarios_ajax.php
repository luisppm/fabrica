<?php

require_once './db/mysql.php';

$bd_mysql = new bd_mysql();
$conn_mysql = $bd_mysql->conectar_mysql();

if ($_POST['acao'] == "salvar") {
    if ($_POST['id']) {
        $UPDATE = "UPDATE usuarios SET nome='" . $_POST['nome'] . "', usuario='" . $_POST['usuario'] . "', email='" . $_POST['email'] . "', ativo='" . $_POST['ativo'] . "', idsetor=" . $_POST['setor'] . ", idgrupo=" . $_POST['grupo'] . " WHERE id=" . $_POST['id'];
        if (mysqli_query($conn_mysql, $UPDATE)) {
            echo "1";
        } else {
            echo "0";
        }
    } else {
        $insert = "INSERT INTO usuarios (nome, usuario, senha, email, ativo, idsetor, idgrupo) VALUES ('" . $_POST['nome'] . "', '" . $_POST['usuario'] . "', '" . sha1($_POST['pwd']) . "', '" . $_POST['email'] . "', 'S', " . $_POST['setor'] . ", " . $_POST['grupo'] . ")";
        if (mysqli_query($conn_mysql, $insert)) {
            echo '1';
        } else {
            echo '0';
        }
    }
}

if ($_POST['acao'] == "excluir") {
    $delete = "DELETE FROM usuarios WHERE id=" . $_POST['id'];
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






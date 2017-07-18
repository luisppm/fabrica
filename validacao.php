
<?php

// Verifica se houve POST e se o usu�rio ou a senha �(s�o) vazio(s)
if (!empty($_POST) AND ( empty($_POST['usuario']) OR empty($_POST['senha']))) {
    header("Location: index.php");
    exit;
}


// Tenta se conectar ao servidor MySQL
$db = mysqli_connect('localhost', 'root', '') or trigger_error(mysql_error());
//mysql_connect('localhost', 'root', '') or trigger_error(mysql_error());
// Tenta se conectar a um banco de dados MySQL
$con = mysqli_select_db($db, 'fabrica') or trigger_error(mysql_error());

$usuario = mysqli_real_escape_string($db, $_POST['usuario']);
$senha = mysqli_real_escape_string($db, $_POST['senha']);

echo "$usuario - $senha ".sha1($senha)." <br>";

// Valida��o do usu�rio/senha digitados
$sql = "SELECT id, nome, nivel FROM usuarios WHERE (usuario = '" . $usuario . "') AND (senha = '" . sha1($senha) . "') AND (ativo = 'S') LIMIT 1";
echo "$sql<br>";
$query = mysqli_query($db, $sql);
if (mysqli_num_rows($query) != 1) {
    // Mensagem de erro quando os dados s�o inv�lidos e/ou o usu�rio n�o foi encontrado
    //header("Location: nologin.php");
    header("Location: login.php?action=fail");
    
    exit;
} else {
    // Salva os dados encontados na vari�vel $resultado
    $resultado = mysqli_fetch_assoc($query);

    // Se a sess�o n�o existir, inicia uma
    if (!isset($_SESSION))
        session_start();

    // Salva os dados encontrados na sess�o
    $_SESSION['UsuarioID'] = $resultado['id'];
    $_SESSION['UsuarioNome'] = $resultado['nome'];
    $_SESSION['UsuarioNivel'] = $resultado['nivel'];

    // Redireciona o visitante
    header("Location: index.php");
    exit;
}
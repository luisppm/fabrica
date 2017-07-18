<?php
require_once './template/template.class.php';

$template_html = new template();

echo $template_html->topo();

echo $template_html->inicioBody();
?>


<?php echo $template_html->menu(); ?>
<div class="container">
    <?php
    // A sessão precisa ser iniciada em cada página diferente
    if (!isset($_SESSION))
        session_start();

    $nivel_necessario = 2;
    // Verifica se não há a variável da sessão que identifica o usuário
    //if (!isset($_SESSION['UsuarioID']) OR ( $_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    if (!isset($_SESSION['UsuarioID'])) {
        // Destrói a sessão por segurança
        session_destroy();
        // Redireciona o visitante de volta pro login
        header("Location: login.php");
        exit;
    }
    ?>
    <p>Olá, <?php echo $_SESSION['UsuarioNome']; ?>! <a href="logout.php">Sair</a></p>

</div>
    <?php
    $template_html->fimBody();



    
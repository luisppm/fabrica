<?php
require_once './template/template.class.php';

$template_html = new template();

echo $template_html->topo();

echo $template_html->inicioBody();
?>


<?php echo $template_html->menu(); ?>
<div class="container">
    <?php
    // A sess�o precisa ser iniciada em cada p�gina diferente
    if (!isset($_SESSION))
        session_start();

    $nivel_necessario = 2;
    // Verifica se n�o h� a vari�vel da sess�o que identifica o usu�rio
    //if (!isset($_SESSION['UsuarioID']) OR ( $_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    if (!isset($_SESSION['UsuarioID'])) {
        // Destr�i a sess�o por seguran�a
        session_destroy();
        // Redireciona o visitante de volta pro login
        header("Location: login.php");
        exit;
    }
    ?>
    <p>Ol�, <?php echo $_SESSION['UsuarioNome']; ?>! <a href="logout.php">Sair</a></p>

</div>
    <?php
    $template_html->fimBody();



    
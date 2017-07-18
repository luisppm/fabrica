<?php
require_once './template/template.class.php';

$template_html = new template();

echo $template_html->topo();

$msg = '';
$display = 'none';
if (!empty($_GET['action'])) {
    $msg = "Usuário ou senha incorreto!";
    $display = 'block';
}
?>


<script>
    $(document).ready(function () {
        $("#usuario").focus();
    });
</script>
<?php echo $template_html->inicioBody() ?>

<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title">Fábrica | Acesso</div>

            </div>
            <div style="padding-top:30px" class="panel-body" >
                <div style="display:<?= $display; ?>" id="login-alert" class="alert alert-danger col-sm-12"><?= $msg; ?></div>
                <div class="modal-body">
                    <form class="form-inline"  action="validacao.php" method="post">


                        <div style="margin-bottom: 25px" class="input-group">
                            <label for="txUsuario">Usuário:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" >
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <label for="txtSenha">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="******">
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <button type="submit" class="btn btn-success">Entrar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>                
    </div>

</div>

<?php
echo $template_html->fimBody();




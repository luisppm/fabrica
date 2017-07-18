<!DOCTYPE html>
<html lang="en">
    <head>
        <!--<meta charset="utf-8">-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>F�brica 1.0</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar">aa</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

            </div>
        </nav>
        <div class="container">
            <?php
            // A sess�o precisa ser iniciada em cada p�gina diferente
            if (!isset($_SESSION))
                session_start();

            $nivel_necessario = 2;
            // Verifica se n�o h� a vari�vel da sess�o que identifica o usu�rio
            if (!isset($_SESSION['UsuarioID']) OR ( $_SESSION['UsuarioNivel'] < $nivel_necessario)) {
                // Destr�i a sess�o por seguran�a
                session_destroy();
                // Redireciona o visitante de volta pro login
                header("Location: index.php");
                exit;
            }
            ?>

            
            <p>Ol�, <?php echo $_SESSION['UsuarioNome']; ?>!</p>
            <a href="logout.php">sair</a>

        </div>

    </body>
</html>


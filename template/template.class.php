<?php

class template {

    function topo() {
        $html = '<!DOCTYPE html>
<html lang="en">
    <head>
        <!--<meta charset="utf-8">-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fábrica 1.0</title>
        <!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->



        <script src="js/jquery-ui/jquery-1.12.4.js"></script>
        <script src="js/jquery-ui/jquery-ui.js"></script>
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/datagridGeral.js"></script>

        <script src="js/bootstrap.min.js"></script>



        <!-- Bootstrap -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/tablecss.css" rel="stylesheet">
        <link href="css/jquery.dataTables.css" rel="stylesheet">';
        return $html;
    }
    
    function menu(){
        $html = '<nav class="navbar navbar-inverse" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">In&iacute;cio</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="clientes.php">Clientes</a></li>
                                <li><a href="#">Produtos</a></li>
                                <li><a href="#">Fornededores</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="usuarios.php">Usuários</a></li>
                                <li><a href="menu.php">Menu</a></li>
                            </ul>
                        </li>
                        <li><a href="clientes.php">Estoque</a></li>
                    </ul>
                </div>
            </div>
        </nav>';
        return $html;
    }
    
    function inicioBody(){
        $html = '    </head>
    <!--<body style="background-repeat: no-repeat; background-position: 200px 200px; background-image: url(\'imagens/Factory_icon-icons.com_52104.png\')">-->
    <body>';
    }

    function fimBody() {
        $html = '<!--</div> div container-->
    </body>
</html>';
    }

}

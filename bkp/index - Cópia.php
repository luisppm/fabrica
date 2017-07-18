<!DOCTYPE html>
<html lang="en">
    <head>
        <!--<meta charset="utf-8">-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fábrica 1.0</title>
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
            <!-- Formulário de Login -->

            <form action="validacao.php" method="post">
                <fieldset>
                    <legend>Acesso</legend>
                    <label for="txUsuario">Usuário</label>
                    <input type="text" name="usuario" id="txUsuario" maxlength="25" />
                    <label for="txSenha">Senha</label>
                    <input type="password" name="senha" id="txSenha" />

                    <input type="submit" value="Entrar" />
                </fieldset>
            </form>
        </div>

    </body>
</html>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


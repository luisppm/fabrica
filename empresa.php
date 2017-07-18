<?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION))
    session_start();

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: login.php");
    exit;
}

require_once './db/mysql.php';

$conn_mysql = new bd_mysql();

$sqlempresa = "SELECT empresa.id, empresa.cnpj, empresa.razao, empresa.inscricao_estadual, DATE_FORMAT(empresa.cadastro,'%d/%m/%Y %k:%i') as cadastro FROM empresa";
$query_empresa = mysqli_query($conn_mysql->conectar_mysql(), $sqlempresa);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--<meta charset="utf-8">-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fábrica 1.0</title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
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
        <link href="css/jquery.dataTables.css" rel="stylesheet">


        <script>
            $(document).ready(function () {
                $(".editar").click(function () {
                    var idregistro = $(this).parents('td').find('input[type="hidden"]').val();
                    alert(idregistro);
                    $.ajax({
                        type: "POST",
                        data: {
                            acao: "editar",
                            id: idregistro
                        },
                        dataType: 'json',
                        url: "usuarios_ajax.php",
                        success: function (data) {
                            $('#myModal').modal('show');
                            $('#inputId').val(data.id);
                            $('#inputName').val(data.nome);
                            $('#inputUsuario').val(data.usuario);


                            $('#inputEmail').val(data.email);
                            $('#optGrupo option[value=' + data.idgrupo + ']').attr('selected', 'selected');
                            $('#optSetor option[value=' + data.idsetor + ']').attr('selected', 'selected');
                            $('#optAtivo option[value=' + data.ativo + ']').attr('selected', 'selected');
                            $('#campoativo').attr('style', 'display:block');


                        },
                        error: function () {
                            alert("Falha ao exibir os dados.");
                        }
                    });
                });

                $(".deletar").click(function () {

                    var idregistro = $(this).parents('td').find('input[type="hidden"]').val();

                    //alert("teste: " + idregistro);
                    //$('#alert').modal({backdrop: "static"});
                    if (confirm("Deseja remover o registro")) {
                        $.ajax({
                            type: "POST",
                            data: {
                                acao: "excluir",
                                id: idregistro
                            },
                            url: "usuarios_ajax.php",
                            success: function (data) {
                                //here data will contain all output from .php, so for your script it will equal to $lang['empty'], you ca do whatever you want with data
                                //f.e. set to modal
                                if (data == '1') {

                                    //$('#myModal').modal('toggle');
                                    alert('Registro removido com sucesso!');
                                    location.reload();
                                } else {
                                    alert("Fail");
                                }
                            },
                            error: function (data) {
                                alert("Não foi possível inserir o registro."); //error message
                            }
                        });
                    }

                });

                $("#btnClose").click(function () {
                    $('#myModal').modal('hide');
                    $("#myModal").find('input, textarea').each(function () {
                        $(this).val('');
                    });
                    $("#myModal").find('select').each(function () {
                        $(this).val('0');
                    });
                });


                $("#btnSalvar").click(function () {
                    $.ajax({
                        type: "POST",
                        data: {
                            acao: 'salvar',
                            id: $('#inputId').val(),
                            nome: $('#inputName').val(),
                            usuario: $('#inputUsuario').val(),
                            pwd: $('#inputPassword').val(),
                            grupo: $('#optGrupo').val(),
                            ativo: $('#optAtivo').val(),
                            setor: $('#optSetor').val(),
                            email: $('#inputEmail').val()
                        },
                        url: "usuarios_ajax.php",
                        success: function (data) {
                            //here data will contain all output from .php, so for your script it will equal to $lang['empty'], you ca do whatever you want with data
                            //f.e. set to modal
                            if (data == '1') {

                                //$('#myModal').modal('toggle');
                                //$("#myModal").remove();
                                location.reload();
                                $('#myModal').modal('hide');
                                $("#myModal").find('input, textarea').each(function () {
                                    $(this).val('');
                                });
                                $("#myModal").find('select').each(function () {
                                    $(this).val('0');
                                });

                            } else {
                                alert("Fail");
                            }
                        },
                        error: function (data) {
                            alert("Não foi possível inserir o registro."); //error message
                        }
                    });
                });
            });




        </script>

    </head>
    <body>
        <nav class="navbar navbar-inverse" role="navigation">
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
                                <li><a href="#">Clientes</a></li>
                                <li><a href="#">Produtos</a></li>
                                <li><a href="#">Fornededores</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Usuários</a></li>
                            </ul>
                        </li>
                        <li><a href="clientes.php">Estoque</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--<div class="jumbotron">-->
        <div class="container">
            <div class="page-header">
                <h2>Usuários</h2>
            </div>
            <table id="tblDados" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>CNPJ</th>
                        <th>Incrição Estadual</th>
                        <th>Razão</th>
                        <th>Data Cadastro</th>
                        <th>Ativo</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Código</th>
                        <th>CNPJ</th>
                        <th>Incrição Estadual</th>
                        <th>Razão</th>
                        <th>Data Cadastro</th>
                        <th>Ativo</th>
                        <th>&nbsp;</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    while ($registro_empresa = mysqli_fetch_array($query_empresa)) {
                        ?>
                        <tr>
                            <td><?php echo $registro_empresa['id'] ?></td>
                            <td><?php echo $registro_empresa['cnpj'] ?></td>
                            <td><?php echo $registro_empresa['razao_social'] ?></td>
                            <td><?php echo $registro_empresa['inscricao_estadual'] ?></td>
                            <td><?php echo $registro_empresa['cadastro'] ?></td>
                            <td><?php echo ($registro_empresa['ativo'] == 'S' ? 'Sim' : 'Não') ?></td>
                            <td>
                                <input type="hidden" id="test" value="<?php echo $registro_empresa['id'] ?>">
                                <img src="imagens/icons/edit.png" title="Editar registro" style="cursor: pointer;" class="editar">
                                <img src="imagens/icons/delete.png" title="Excluir registro" style="cursor: pointer;" class="deletar">
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <hr>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                + Novo registro
            </button>

            <!-- Modal confirmar-->
            <div class="modal fade" id="alert">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Mensagem</h4>
                        </div>
                        <div class="modal-body">

                            <h4><img src="imagens/icons/warning.png" />Deseja remover o registro?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnConfirmar">Confirmar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>        
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal form-->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Cadastro de Empresas</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="">

                                <input type="hidden" id="inputId" value=""/>
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label" for="inputCnpj">CNPJ:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputCnpj" maxlength="50"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="inputRazao" >Razão Social:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="inputRazao" maxlength="25"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="inputincricaoEstadual" >Incrição Estadual:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="inputInscricaoEstadual" maxlength="8"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="campoativo" style="display:  none;">
                                        <label class="col-sm-2 control-label" for="inputAtivo" >Ativo:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="optAtivo" name="optAtivo">
                                                <option value="N">Não</option>
                                                <option value="S">Sim</option>                                            
                                            </select>                                        
                                        </div>                                

                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnSalvar">Salvar</button>
                            <button type="button" class="btn btn-default" id="btnClose">Fechar</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
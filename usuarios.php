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
require_once './template/template.class.php';

$conn_mysql = new bd_mysql();
$template_html = new template();

$sqlusuario = "SELECT id, nome, usuario, senha, email, ativo, idsetor, idgrupo, DATE_FORMAT(usuarios.cadastro,'%d/%m/%Y %k:%i') as cadastro FROM usuarios";
$query_usuario = mysqli_query($conn_mysql->conectar_mysql(), $sqlusuario);

echo $template_html->topo();
?>

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
    <?php echo $template_html->menu(); ?>
    <!--<div class="jumbotron">-->
    <div class="container">
        <div class="page-header">
            <h2>Usuários</h2>
        </div>
        <table id="tblDados" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Usuário</th>
                    <th>email</th>
                    <th>Data Cadastro</th>
                    <th>Ativo</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Usuário</th>
                    <th>email</th>
                    <th>Data Cadastro</th>
                    <th>Ativo</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                while ($registro_usuario = mysqli_fetch_array($query_usuario)) {
                    ?>
                    <tr>
                        <td><?php echo $registro_usuario['nome'] ?></td>
                        <td><?php echo $registro_usuario['usuario'] ?></td>
                        <td><?php echo $registro_usuario['email'] ?></td>
                        <td><?php echo $registro_usuario['cadastro'] ?></td>
                        <td><?php echo ($registro_usuario['ativo'] == 'S' ? 'Sim' : 'Não') ?></td>
                        <td>
                            <input type="hidden" id="test" value="<?php echo $registro_usuario['id'] ?>">
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
                        <h4 class="modal-title" id="myModalLabel">Cadastro de Usuários</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="">

                            <input type="hidden" id="inputId" value=""/>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label" for="inputName">Nome:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Nome" maxlength="100"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="inputUsuario3" >Usuário:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputUsuario" placeholder="Usuário" maxlength="25"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="inputPassword3" >Senha:</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="inputPassword" placeholder="Senha"  maxlength="8"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="inputSetor" >Setor:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="optSetor" name="optSetor">
                                        <option value="0">Selecione</option>
                                        <option value="1">Vendas</option>
                                        <option value="2">Estoque</option>
                                        <option value="2">Administraçao</option>
                                    </select>                                        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="inputGrupo" >Grupo:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="optGrupo" name="optGrupo">
                                        <option value="0">Selecione</option>
                                        <option value="1">Administração</option>
                                        <option value="2">TI</option>
                                        <option value="2">Reprensentantes</option>
                                    </select>                                        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="inputEmail" >email:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="email"  maxlength="100"/>
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
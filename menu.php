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

$sqlmenu = "SELECT menu.id, menu.descricao, menu.link, menu.nivel, menu.id_pai, menu.status FROM menu";
$query_menu = mysqli_query($conn_mysql->conectar_mysql(), $sqlmenu);

echo $template_html->topo();
?>



<script>
    $(document).ready(function () {
        $(".addopt").click(function () {
            var idregistro = $(this).parents('td').find('input[type="hidden"]').val();
            $.ajax({
                type: "POST",
                data: {id: idregistro},
                dataType: 'json',
                url: "opcoesMenu.php",
                success: function (data) {
                    $('#modalAddOpt').modal('show');
                    $('#inputIdPai').val(data.id);
                    $('#inputDescricaoPai').val(data.descricaoPai);
                },
                error: function () {
                    alert("Falha ao exibir os dados.");
                }
            });
        });


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
                    descricao: $('#inputDescricao').val(),
                    link: $('#inputLink').val(),
                    nivel: $('#optNivel').val(),
                    id_pai: $('#inputPai').val(),
                    status: $('#optStatus').val(),
                },
                url: "menu_ajax.php",
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

<?php
echo $template_html->inicioBody();

echo $template_html->menu();
?>

<!--<div class="jumbotron">-->
<div class="container">
    <div class="page-header">
        <h2>Menu</h2>
    </div>
    <table id="tblDados" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>&nbsp;</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            if ($query_menu) {


                while ($registro_menu = mysqli_fetch_array($query_menu)) {
                    ?>
                    <tr>
                        <td><?php echo $registro_menu['id'] ?></td>
                        <td><?php echo $registro_menu['descricao'] ?></td>
                        <td><?php echo $registro_menu['status'] ?></td>
                        <td>
                            <input type="hidden" id="codigo_id" value="<?php echo $registro_menu['id'] ?>">
                            <img src="imagens/icons/edit.png" title="Editar registro" style="cursor: pointer;" class="editar">
                            <img src="imagens/icons/delete.png" title="Adicionar Opção" style="cursor: pointer;" class="addopt">
                            <img src="imagens/icons/delete.png" title="Excluir registro" style="cursor: pointer;" class="deletar">
                        </td>
                    </tr>
                    <?php
                }
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

    <!-- Modal add opção form-->
    <div class="modal fade" id="modalAddOpt" tabindex="-1" role="dialog" aria-labelledby="modalAddOptLabel" data-backdrop="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Inserir opção</h4>
            </div>
            <div class="modal-body">
                teste opção
            </div>
        </div>
    </div>
    <!-- Modal add opção form-->

    <!-- Modal form-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cadastro de Menu</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="">

                        <input type="hidden" id="inputId" value=""/>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label" for="inputDescricao">Descrição</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputDescricao" maxlength="20"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputLink" >Link:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="inputLink" maxlength="100"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="optNivel" >Nível:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="optNivel" name="optNivel">
                                    <option value="1">1</option>
                                    <option value="2">2</option>                                            
                                </select>                                        
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label" for="inputPai">Menu Pai</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPai" maxlength="20"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="optStatus" >Status:</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="optStatus" name="optStatus">
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>                                            
                                    <option value="I">Manutenção</option>                                            
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
?<?php echo $template_html->fimBody(); ?>
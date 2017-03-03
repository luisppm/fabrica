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

$sqlusuario = "SELECT id, tipo_cliente, cpf_cnpj, rg, nome, DATE_FORMAT(clientes.cadastro,'%d/%m/%Y %k:%i') as cadastro, DATE_FORMAT(clientes.data_ultima_compra, '%d/%m/%Y') as dataultimacompra, ativo FROM clientes";
$query_usuario = mysqli_query($conn_mysql->conectar_mysql(), $sqlusuario);

echo $template_html->topo();
?>
<script>
    $(document).ready(function () {
        $("#novoRegsitro").click(function () {
            location.replace('clientesNovo.php');
        });
    });
</script>

<?php
echo $template_html->inicioBody();
echo $template_html->menu();
?>

<div class="container">
    <div class="page-header">
        <h2>Clientes</h2>
    </div>
    <table id="tblDados" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Tipo</th>
                <th>CPF/CNPJ</th>
                <th>RG</th>
                <th>Nome</th>
                <th>Cadastro</th>
                <th>Últ. Compra</th>
                <th>Ativo</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Cód.</th>
                <th>Tipo</th>
                <th>CPF/CNPJ</th>
                <th>RG</th>
                <th>Nome</th>
                <th>Cadastro</th>
                <th>Últ. Compra</th>
                <th>Ativo</th>
                <th>&nbsp;</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            while ($registro_usuario = mysqli_fetch_array($query_usuario)) {
                ?>
                <tr>
                    <td><?php echo $registro_usuario['id'] ?></td>
                    <td><?php echo $registro_usuario['tipo_cliente'] ?></td>
                    <td><?php echo $registro_usuario['cpf_cnpj'] ?></td>
                    <td><?php echo $registro_usuario['rg'] ?></td>
                    <td><?php echo $registro_usuario['nome'] ?></td>
                    <td><?php echo $registro_usuario['cadastro'] ?></td>
                    <td><?php echo $registro_usuario['dataultimacompra'] ?></td>
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
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" id="novoRegsitro">
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
</div>
<?php echo $template_html->fimBody(); ?>
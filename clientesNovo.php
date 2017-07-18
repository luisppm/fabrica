<?php
require_once './db/mysql.php';
require_once './template/template.class.php';

$conn_mysql = new bd_mysql();
$template_html = new template();

$id = '';
if (!empty($_POST['id'])) {
    $id = $_POST['id'];
}
echo $template_html->topo();
?>
<script>
    $(document).ready(function(){
        $("#btnCancelar").click(function () {
            location.replace('clientes.php');
        });
        $("#btnSalvarAdd").click(function (){
            alert('adicionar e manter');
        });
        $("#btnSalvar").click(function(){
            alert('adicionar e sair');
        });
    });
    
    
    </script>
<?php
echo $template_html->menu();
?>
<div class="container">
    <div class="page-header">
        <h2>Cadastro de Clientes</h2>
    </div>


    <form class="form-horizontal" method="POST" action="">
        <input type="hidden" id="inputId" value=""/>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="optTipoCliente" >Tipo Cliente:</label>
            <div class="col-sm-3">
                <select class="form-control" id="optTipoCliente" name="optTipoCliente">
                    <option value="F">Física</option>
                    <option value="J">Jurídica</option>
                </select>                                        
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label" for="inputCpfCnpj">CPF/CNPJ:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputCpfCnpj" maxlength="100"/>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label" for="inputRg">RG:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inputRg" maxlength="100"/>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label" for="inputNome">Nome:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputNome" maxlength="100"/>
            </div>
        </div>

    </form>
    <div class="modal-footer" style="margin-left: 10px; margin-top: 5px; ">
        <button type="button" class="btn btn-primary" id="btnSalvar">Salvar</button>
        <button type="button" class="btn btn-primary" id="btnSalvarAdd">Salvar e Adicionar</button>
        <button type="button" class="btn btn-default" id="btnCancelar">Cancelar</button>
    </div> 
</div>
<?php
echo $template_html->fimBody();

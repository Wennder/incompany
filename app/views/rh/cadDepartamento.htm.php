<script type="text/javascript">
    $(document).ready(function() {
        $("#formCadDep").validate({
            errorContainer: "#errConteiner",
            rules: {
                nome: {
                    required:true
                }
            },
            messages: {
                nome: {
                    required:"Digite o nome."
                }
            }
        });
        $("#cadDepartamento").dialog({
            autoOpen:false,
            title:"Novo Departamento",
            modal:true,
            width: 470,
            height: 230
        });
        $("#openDialog").click(function(){
            $("#cadDepartamento").dialog("open");
        });
    });
</script>
<?php
$this->pageTitle = "RH :: Departamentos";
echo $html->link("Novo Departamento", "javascript:void(0);", array("id" => "openDialog", "class" => "botao"));
echo "<br/>";
echo "<br/>";
?>
<div class="borda ui-corner-all">
    <?php
    echo $xgrid->start($listSetor)
            ->caption("Departamentos Cadastrados")
            ->col('sys_permissoes')->hidden()
            ->col('sys_permissoes_id')->hidden()
            ->col('nome')->title('Nome')
            ->col('email')->title('Email Principal')
            ->col('id')->hidden()
            ->col('sysEmpresas_id')->hidden()
            ->col('created')->hidden()
            ->noData('Nenhum registro encontrado')
            ->alternate("grid_claro", "grid_escuro");
    ?>
</div>

<div id="cadDepartamento" style="height:180px">
    <?php
    echo $form->create("", array("id" => "formCadDep"));
    ?>
    <div id="dadosAcesso" class="ladoalado">
        <?php
        echo $form->input("nome", array("type" => "text", "label" => "Nome do Depto", "class" => "Form2Blocos", "div" => "ladoalado"));
        echo $form->input("email", array("type" => "text", "label" => "Email Principal", "class" => "Form2Blocos"));
        echo $form->input("sys_permissoes_id", array("type" => "select", "options" => $nivelpermissao, "label" => "Nivel de permissão do Dpto.", "class" => "Form1Bloco"));
        echo "<br/>";
        echo "&nbsp;&nbsp;".$form->close("Inserir");
        ?>
    </div> 
</div>
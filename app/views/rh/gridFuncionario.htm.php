<script type="text/javascript">
    $(function() {
        $("#anexDoc").dialog({
            height: 280,
            width:550,
            modal: true,
            autoOpen:false,
            beforeClose:function(){
                $("#anexDoc").html("");
            }
        });
        $("#Fich").dialog({
            height: 280,
            width:550,
            modal: true,
            autoOpen:false,
            beforeClose:function(){
                $("#Fich").html("");
            }
        });
        
        $("#openSearch").click(function(){
            $('#Search').dialog('open');
        });
        
        $("#Search").dialog({
            height: 310,
            width:550,
            modal: true,
            autoOpen:false
        });
    });

</script>
<?php
$this->pageTitle = "RH :: Listagem de Funcionários";
echo $xgrid->start($dadosUsuarios)
        ->caption("Funcionários")
        ->hidden(array("id", "grupoEmpresa_id", "dt_desligamento", "sysEmpresas_id", "financeiro_bancos", "gerente_funcionario", "foto", "documentos"))
        ->col('estado')->title()->conditions("dt_desligamento", array("0" => array(), "!=0" => "ban.gif"))->position(0)
        ->col('nome')->title('Nome')->slice(50)
        ->col("grupo_empresa")->title("G. Empresa")->cellArray("nome")
        ->col("empresa")->cellArray("nomeFantasia")
        ->col('rh_setor_id')->hidden()
        ->col('rh_setor')->hidden()
        ->col('verMais')->conditions('id', array(
            ">=1" => array("label" => "mais.png", "href" => "javascript:popIn('Fich','/rh/fichaFuncionario/{id}');", "border" => "0")
        ))->title()
        ->col('editar')->conditions('id', array(
            ">=1" => array("label" => "editar.png", "href" => "/rh/cadFuncionario/{id}", "border" => "0")
        ))->title()
        ->col("imprimir")->title("")->cell("icone_imprimir.gif", "/rh/printFichaCompleta/{id}", array("border" => "0"))
        ->noData('Nenhum Funcionário encontrado')
        ->alternate("grid_claro", "grid_escuro");

//pr ($dadosUsuarios);
?>
<a href="/rh/cadFuncionario/" class="botao">Novo</a>&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
<a href="javascript:void(0);" id="openSearch" class="botao">Buscar</a>&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;

<?php
$pagination->model("users");
echo $pagination->first("Primeiro", array("class" => "botao"));
echo $pagination->previous("Anterior", array("class" => "botao"));
echo $pagination->next("Próximo", array("class" => "botao"));
echo $pagination->last("Último", array("class" => "botao"));
?>


<div id="anexDoc" title="Anexar Documento"></div>
<div id="Fich" title="Ficha do Funcionário"></div>
<div id="Search" title="Buscar">
    <script>
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
    </script>
    <fieldset>
        <legend>Buscar por nome</legend>
        <?php
        echo $form->create("/rh/gridFuncionario");
        echo $form->input("nome", array("class" => "Form2Blocos", "label" => "Nome ou Sobrenome ou Mínimo 3 letras do Nome"));
        echo $form->input("estado", array("type" => "select", "class" => "Form2Blocos", "options" => array("Indiferente", "Ativo", "Desativado")));
        echo $html->openTag("br", array(), true);
        echo $html->openTag("center");
        echo $form->close("Buscar");
        echo $html->closeTag("center");
        ?>
        <br>
    </fieldset>
</div>
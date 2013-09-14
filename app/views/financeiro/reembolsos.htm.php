<script>
    $(function(){
        $("#filtro").dialog({
            autoOpen: false,
            modal:true,
            height:250,
            width:475
        });
        $("#editarPedido").dialog({
            autoOpen: false,
            modal:true,
            height:450,
            width:465
        });

    });
</script>
<?php
$this->pageTitle = "Financeiro :: Reembolsos";
//pr($aPagar);
echo $form->create('/financeiro/acaoReembolso');
echo $xgrid->start($aPagar)
        ->caption("Reembolsos aguardando pagamento")
        ->col("status_id")->hidden()
        ->col("tipodespesa")->hidden()
        ->col("financeiro_pago")->hidden()
        ->col("rh_funcionarios")->title("Funcionário")->cellArray("nome")->position(1)
        ->col('beneficiario')->hidden()
        ->col('chk')->checkbox('checado[]', '{id}')->title('')->position(0)
        ->col('id')->title('#')->position(1)
        ->col('valor')->currency('R$', 2, ',', '.')->position(3)
        ->col('created')->date("d/m/Y")->title("Data")
        ->col('modified')->date("d/m/Y")->title("Ult. Modificação")
        ->col("financeiro_motivodespesa")->hidden()
        ->col('Estado')->conditions('status_id', $statusDespesa)
        ->col('Ver')->cell("mais.png", "javascript:AbreJanela('/financeiro/editarReembolso/{id}',500,500,'Pedido de Reembolso nº {id}');")
        ->footer('valor')->sumReal() //Função desenvolvida com a finalide de fazer a soma de valores reais.
        ->noData('Nenhum Pedido Encontrado')
        ->alternate("grid_claro", "grid_escuro");
?>
<?php
echo $form->input('acao', array("type" => "select", "label" => "Com selecionados mudar para", "options" => $statusFinanceiro, "class" => "Form1Bloco", "div" => "ladoalado"));
echo $form->close('Enviar', array('class' => 'ladoalado botao'));
echo $html->link("Buscar", "javascript:popIn('filtro','');", array("id" => "bntFiltro", "class" => "botao"));
?>
<br />

<div id="filtro" title="Filtro de Reembolsos">
    <?php
    echo $form->create('');
    echo $form->input('gerente', array("type" => "select", "label" => "Funcionário / Gerente", "class" => "Form2Blocos", "options" => $funcionarios));
    echo $form->input('dataInicio', array("label" => "Data Inicial", "div" => "ladoalado", "class" => "Form1Bloco", "alt" => "date", "value" => date("d/m/Y", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")))));
    echo $form->input('dataFim', array("label" => "Data Final", "class" => "Form1Bloco", "alt" => "date", "value" => date("d/m/Y")));

    echo $form->input("status", array("type" => "select", "label" => "Status", "class" => "Form1Bloco", "options" => $statusFinanceiro));
    echo "<center>";
    echo $form->close("Filtrar", array("class" => "Form1Bloco"));
    echo "</center>";
    ?>
</div>


<div id="editarPedido" title="Meus pedidos de reembolso"></div>
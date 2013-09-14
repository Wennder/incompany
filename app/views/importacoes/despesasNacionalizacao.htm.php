<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#FormNomecusto").autocomplete({
            source: "/integracao/autocomplete/importacoes_nomecustos/nome/",
            minLength: 3,
            select: function(event, ui){
                $("#FormCustoId").val(ui.item.id);
            }
        });
        
        $("#formDespesas").ajaxForm(function() {
            loadDiv('#contDespesasNacionalizacao','/importacoes/despesasNacionalizacao/grid/<?php echo $processo ?>');
            $("#qtdItens").load("/importacoes/despesasNacionalizacao/count/<?php echo $processo; ?>");
            $("#somaItens").load("/importacoes/despesasNacionalizacao/somaTotal/<?php echo $processo; ?>");
        });
        
        $("#setTerminal").ajaxForm(function() {
            alert("Lembre-se de Recalcular o Processo!");
            $("#qtdItens").load("/importacoes/despesasNacionalizacao/count/<?php echo $processo; ?>");
            $("#somaItens").load("/importacoes/despesasNacionalizacao/somaTotal/<?php echo $processo; ?>");
        });
        
    });
</script>
<?php
switch ($op) {
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "processo", "created","modified","custo_id"))
                ->col("custo")->cellArray("nome")->position(1)
                ->col("valorUnitario")->title("Unitário")->currency()
                ->col("valorTotal")->title("Total")->currency()
                ->col("deletar")->title("")->cell("deletar.png","javascript:delAjax('/importacoes/despesasNacionalizacao/deletar/{id}/','contDespesasNacionalizacao', '/importacoes/despesasNacionalizacao/grid/{processo}/')")
                ->col("auto")->title("")->conditions("auto",array("1"=>array("label"=>"red_flag.gif"),"0"=>array("label"=>"green_flag.gif")))->position(0)
                ->footer("valorTotal")->sumReal();
        break;
    case "count":
        $qtd = count($dadosGrid);
        if ($qtd > 0) {
            $sufixo = $qtd . " Itens";
        } else {
            $sufixo = "Nenhum Item";
        }
        echo $sufixo;
        break;
    case "somaTotal":
        echo "R$ " . $dadosGrid["soma"];
        break;
    default :
    case "cadastrar":
        echo $html->tag("script", "loadDiv('#contDespesasNacionalizacao','/importacoes/despesasNacionalizacao/grid/$processo');");
        echo $html->openTag("fieldset");
        echo $html->tag("legend", "Inserir");
        echo $html->openTag("div", array("id" => "contFormDespesas"));
        echo $form->create("", array("id" => "formDespesas","class"=>"formee"));
        echo $form->input("nomeCusto", array("label" => "Nome da Despesa", "div" => "grid-6-12"));
        echo $form->input("custo_id", array("type" => "hidden", "value" => $dadosForm["custo_id"]));
        echo $form->input("valorUnitario", array("alt" => "moeda", "label" => "Valor Unitário", "div" => "grid-6-12", "value" => $dadosForm["valorUnitario"]));
        echo $form->close("Inserir", array("class" => "botao grid-3-12"));
        echo $html->closeTag("div");
        echo $html->closeTag("fieldset");

        echo $html->openTag("fieldset");
        echo $html->tag("legend", "Despesas Cadastradas");
        echo $html->tag("div", "", array("id" => "contDespesasNacionalizacao","style"=>"overflow:auto; height:400px;"));
        echo $html->closeTag("fieldset");
        break;
    case "setTerminal":
        echo $form->create("",array("id"=>"setTerminal","class"=>"formee"));
        echo $form->input("terminalAtraque",array("type"=>"select","label"=>"Terminal de Atraque","div"=>"grid-12-12","options"=>$optTerminais,"value"=>$dadosForm["terminalAtraque"]));
        echo $form->close("Salvar",array("class"=>"botao grid-3-12"));
        break;
}
?>

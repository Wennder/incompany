<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#formConfigCustos").ajaxForm(function(data) {
            alert(data);
            loadDiv("#contImportacoes","/importacoes/config_custosTerminais/grid/<?php echo $idTerminal ?>");
        });
        
        $("#FormNomecusto").autocomplete({
        source: "/integracao/autocomplete/importacoes_nomecustos/nome/",
        minLength: 3,
        select: function(event, ui){
            $("#CustoID").val(ui.item.id);
        }
    });
    });
</script>
<?php
switch ($op) {
    default :

        break;
    case "grid":
        echo $html->tag("h3", $dadosGrid[0]["terminal"]["nome"],array("class"=>"title"));
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro","grid_escuro")
                ->hidden(array("id","terminal","terminais_id","custo_id","created","modified"))
                ->col("valorUnitario")->currency("R$ ")->title("Valor Unitário")
                ->col("formaCalculo")->title("Cálculo")
                ->col("custo")->cellArray("nome")->position(0)
                ->col("editar")->title("")->cell("editar.png", "javascript:AbreJanela('/importacoes/config_custosTerminais/cadastrar/{terminais_id}/{id}', 500, 250, 'Editar Custo', null, true);")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/config_custosTerminais/deletar/{id}','contImportacoes','/importacoes/config_custosTerminais/grid/{terminais_id}');");
        
        echo $html->link("Novo","javascript:AbreJanela('/importacoes/config_custosTerminais/cadastrar/{$idTerminal}/', 500, 250, 'Inserir Custo no Terminal {$dadosGrid["nome"]}', null, true)",array("class"=>"botao"));
        break;
    case "cadastrar":
        echo $form->create("",array("id"=>"formConfigCustos","class"=>"formee"));
        echo $form->input("nomeCusto",array("label"=>"Nome da Despesa","value"=>$dadosForm["custo"]["nome"], "div"=>"grid-12-12"));
        echo $form->input("custo_id",array("id"=>"CustoID","type"=>"hidden","value"=>$dadosForm["custo_id"]));
        echo $form->input("formaCalculo",array("label"=>"Cálculo","value"=>$dadosForm["formaCalculo"], "div"=>"grid-8-12"));
        echo $form->input("valorUnitario",array("alt"=>"moeda","label"=>"Valor Unitário", "div"=>"grid-4-12","value"=>$dadosForm["valorUnitario"]));
        echo $form->close("Inserir",array("class"=>"formee-button"));

        break;
}
?>

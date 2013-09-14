<script>
$(function(){
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
    
    $("#formFabricantes").ajaxForm(function() {
            $("#abaProcesso").tabs('select',"dadosGerais");
            alert("Cadastrado com Sucesso!!!");  
            $("#contFabricantes").load("/importacoes/fornecedoresProcesso/grid/<?php echo $processo; ?>"); 
            return false;
        });
    
   $("#FormNomefornecedor").autocomplete({
        source: "/integracao/autocomplete/estoque_fornecedores/nomeFantasia/",
        minLength: 3,
        select: function(event, ui){
            $("#FormFornecedoresId").val(ui.item.id);
        }
    }); 
});
</script>
<?php
switch ($op){
    default:
        case "grid":
            echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro","grid_escuro")
                ->hidden(array("processo","fornecedores_id","created","modified","id"))
                ->col("dtProducao")->date("d/m/Y")->title("Produção")
                ->col("dtConfirmacao")->date("d/m/Y")->title("Data")->position(4)
                ->col("nConfirmacao")->title("Pedido")
                ->col("confirmado")->conditions($bool)
                ->col("fabricante")->cellArray("nomeFantasia")->title("Fabricante")->position(1)
                ->col("edit")->title("")->cell("editar.png","javascript:AbreJanela('/importacoes/fornecedoresProcesso/cadastrar/{processo}/{id}',440,275,'Editar Fabricante',0,true);")
                ->col("acao")->title("")->cell("deletar.png","javascript:delAjax('/importacoes/fornecedoresProcesso/deletar/{processo}/{id}','contFabricantes', '/importacoes/fornecedoresProcesso/grid/{processo}/')");
            break;
        case "cadastrar":
            echo $form->create("",array("id"=>"formFabricantes","class"=>"formee"));
            echo $form->input("nomeFornecedor",array("label"=>"Fornecedor","value"=>$dadosForm["fabricante"]["nomeFantasia"],"div"=>"grid-12-12"));
            echo $form->input("fornecedores_id",array("type"=>"hidden","value"=>$dadosForm["fabricante"]["id"]));
            
            echo $form->input("confirmado",array("label"=>"Confirmado","div"=>"grid-6-12","type"=>"select","options"=>$bool,"value"=>$dadosForm["confirmado"]));
            echo $form->input("nConfirmacao",array("label"=>"Número do Pedido","div"=>"grid-6-12","value"=>$dadosForm["nConfirmacao"]));
            
            echo $form->input("dtConfirmacao",array("alt"=>"date","label"=>"Data do Pedido","div"=>"grid-6-12", "value"=>$date->format("d-m-Y",$dadosForm["dtConfirmacao"])));
            echo $form->input("dtProducao",array("alt"=>"date","label"=>"Data Produção","div"=>"grid-6-12", "value"=>$date->format("d-m-Y",$dadosForm["dtProducao"])));
            
            echo $form->close("Salvar",array("class"=>"botao grid-3-12"));
            break;
}
?>

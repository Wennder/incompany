<script>
$(function(){
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
    
    $("#FormContratosCambio").ajaxForm(function() {
            $("#abaProcesso").tabs('select',"financeiro");
            alert("Cadastrado com Sucesso!!!");  
            $("#contContratosCambio").load("/importacoes/contratosCambio/grid/<?php echo $processo; ?>"); 
            return false;
        }); 
});
</script>

<?php
switch($op){
    default :
        case "grid":
            echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro","grid_escuro")
                ->hidden(array("id","processo"))
                ->col("condicao")->title("Condição")
                ->col("numero")->title("Número")
                ->col("moedas_id")->title("Moeda")->conditions($optMoedas)
                ->col("data")->date("d/m/Y")
                ->col("acao")->title("")->cell("deletar.png","javascript:delAjax('/importacoes/contratosCambio/deletar/{processo}/{id}','contContratosCambio', '/importacoes/contratosCambio/grid/{processo}/')");
                
            break;
        case "cadastrar":
            echo $form->create("",array("id"=>"FormContratosCambio","class"=>"formee"));
            echo $form->input("condicao",array("label"=>"Condição","div"=>"grid-6-12"));
            echo $form->input("numero",array("label"=>"Nr. do Contrato","div"=>"grid-6-12"));
            
            echo $form->input("moedas_id",array("type"=>"select","options"=>$optMoedas,"label"=>"Moeda","div"=>"grid-6-12"));
            echo $form->input("valor",array("alt"=>"moeda","label"=>"Valor Contrato","div"=>"grid-6-12"));
            
            echo $form->input("taxa",array("alt"=>"moedaProduto","label"=>"Taxa de Câmbio","div"=>"grid-6-12"));
            echo $form->input("data",array("alt"=>"date","label"=>"Data do Contrato","div"=>"grid-6-12"));
            
            echo $form->close("Salvar",array("class"=>"botao grid-3-12"));
            break;
}
?>

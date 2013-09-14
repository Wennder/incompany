<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
       
        $("#formCustoFechamento").ajaxForm(function() {
            $("#abaProcesso").tabs('select',"financeiro");
            alert("Cadastrado com Sucesso!!!");  
            $("#contCustosFechamento").load("/importacoes/custosFechamento/grid/<?php echo $processo; ?>"); 
            return false;
        }); 
    });
</script>
<?php
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro","grid_escuro")
                ->hidden(array("id","processo"))
                ->col("descricao")->title("Descrição")
                ->col("data")->date("d/m/Y")
                ->col("credito")->title("Tipo")->position(2)->conditions($optTipos)
                ->col("acao")->title("")->cell("deletar.png","javascript:delAjax('/importacoes/custosFechamento/deletar/{id}/','contCustosFechamento', '/importacoes/custosFechamento/grid/{processo}/')")
                ->footer("valor")->sumReal();
        break;
    case "cadastrar":
        echo $form->create("",array("id"=>"formCustoFechamento","class"=>"formee"));
        echo $form->input("descricao",array("label"=>"Descrição do $tipo","div"=>"grid-6-12"));
        echo $form->input("data",array("alt"=>"date","label"=>"Data","div"=>"grid-3-12"));
        echo $form->input("valor",array("alt"=>"moeda","label"=>"Valor do $tipo","div"=>"grid-3-12"));
        echo $form->close("Salvar",array("class"=>"botao grid-3-12"));
        break;
}
?>

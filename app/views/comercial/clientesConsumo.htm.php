<script>
    $(function(){
        $("button,.botao, inputsubmit, inputbutton, button", "html").button();
        $("input:text").setMask();
        $("#formConsumoCliente").ajaxForm(function(){
            //sucessRequisition(this,"sucess","Cadastrado com Sucesso");
            alert("Registro Inserido com Sucesso");
            loadDiv("#gridConsumo","/comercial/clientesConsumo/grid/<?php echo $cliente_id; ?>");
        });
        
        $("#FormEstoquecategoria1").load("/integracao/options/estoque_catprodutos/nome/<?php echo empty($dadosForm["estoqueCategoria1"]) ? "0" : $dadosForm["estoqueCategoria1"]; ?>/pai/0");
        $("#FormEstoquecategoria2").load("/integracao/options/estoque_catprodutos/nome/<?php echo empty($dadosForm["estoqueCategoria2"]) ? "0" : $dadosForm["estoqueCategoria2"]; ?>/pai/<?php echo empty($dadosForm["estoqueCategoria1"]) ? "" : $dadosForm["estoqueCategoria1"]; ?>");
        $("#FormEstoquecategoria3").load("/integracao/options/estoque_catprodutos/nome/<?php echo empty($dadosForm["estoqueCategoria3"]) ? "0" : $dadosForm["estoqueCategoria3"]; ?>/pai/<?php echo empty($dadosForm["estoqueCategoria2"]) ? "" : $dadosForm["estoqueCategoria2"]; ?>");
        $("#FormEstoquecategoria4").load("/integracao/options/estoque_catprodutos/nome/<?php echo empty($dadosForm["estoqueCategoria4"]) ? "0" : $dadosForm["estoqueCategoria4"]; ?>/pai/<?php echo empty($dadosForm["estoqueCategoria3"]) ? "" : $dadosForm["estoqueCategoria3"]; ?>");
        
        $("#FormEstoquecategoria1").change(function(){
            $("#FormEstoquecategoria2").load("/integracao/options/estoque_catprodutos/nome/0/pai/"+$("#FormEstoquecategoria1").val());
        });
        
        $("#FormEstoquecategoria2").change(function(){
            $("#FormEstoquecategoria3").load("/integracao/options/estoque_catprodutos/nome/0/pai/"+$("#FormEstoquecategoria2").val());
        });
        
        $("#FormEstoquecategoria3").change(function(){
            $("#FormEstoquecategoria4").load("/integracao/options/estoque_catprodutos/nome/0/pai/"+$("#FormEstoquecategoria3").val());
        });
    });
</script>
<?php
switch ($op) {
    case "cadastrar":
        echo $form->create("", array("id" => "formConsumoCliente", "class" => "formee"));
        echo $form->input("estoqueCategoria1", array("type" => "select", "options" => $optCategorias, "div" => "grid-3-12", "label" => "Grupo", "value" => $dadosForm["estoqueCategoria1"]));
        echo $form->input("estoqueCategoria2", array("type" => "select", "options" => $optCategorias, "div" => "grid-3-12", "label" => "Tipo", "value" => $dadosForm["estoqueCategoria2"]));
        echo $form->input("estoqueCategoria3", array("type" => "select", "options" => $optCategorias, "div" => "grid-3-12", "label" => "Aplicação", "value" => $dadosForm["estoqueCategoria3"]));
        echo $form->input("estoqueCategoria4", array("type" => "select", "options" => $optCategorias, "div" => "grid-3-12", "label" => "Produto Final", "value" => $dadosForm["estoqueCategoria4"]));
        
        echo $form->input("qtdConsumo", array("label" => "Quantidade", "alt" => "moedaProduto", "value" => $dadosForm["qtdConsumo"], "div" => "grid-6-12"));
        echo $form->input("unConsumo", array("type"=>"select","label" => "Unidade", "value" => $dadosForm["unConsumo"], "div" => "grid-6-12","options"=>$unidadesMedida));
        echo $form->input("concorrente", array("label" => "Concorrente", "value" => $dadosForm["concorrente"], "div" => "grid-4-12"));
        echo $form->input("modeloLocal", array("label" => "Modelo", "value" => $dadosForm["modeloLocal"], "div" => "grid-4-12"));
        echo $form->input("precoLocal", array("label" => "Preço (R$)","alt"=>"moedaProduto", "value" => $dadosForm["precoLocal"], "div" => "grid-4-12"));
        
        echo $form->close("Salvar", array("class" => "botao grid-3-12 clear"));
        break;

    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Consumo do Cliente")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "cliente_id", "estoqueCategoria1", "estoqueCategoria2", "estoqueCategoria3", "estoqueCategoria4","concorrente","modeloLocal","unConsumo","precoLocal"))
                ->col("grupo")->title("Grupo")->cellArray("nome")
                ->col("tipo")->title("Tipo")->cellArray("nome")
                ->col("aplicacao")->title("Aplicação")->cellArray("nome")
                ->col("final")->title("Produto Final")->cellArray("nome")
                ->col("qtdConsumo")->title("Qtd")->position(17)
                ->col("modified")->title("Ref.")->date("d/m/Y")->position(19)
                ->col("who")->title("Modificado Por")->position(15)->slice(18)
                ->col("editar")->cell("editar.png", "javascript:AbreJanela('/comercial/clientesConsumo/cadastrar/{cliente_id}/{id}',430,250,'Perfil de Consumo',null,true);")->title("")
                ->col("deletar")->cell("deletar.png","javascript:delAjax('/comercial/clientesConsumo/deletar/{id}','gridConsumo','/comercial/clientesConsumo/grid/{cliente_id}');")->title("");

        echo $html->link("Adicionar", "javascript:AbreJanela('/comercial/clientesConsumo/cadastrar/{$cliente_id}',430,250,'Perfil de Consumo',null,true);", array("class" => "botao grid-3-12"));
        break;
}
?>

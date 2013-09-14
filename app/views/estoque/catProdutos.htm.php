<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#formNovaCategoria").ajaxForm(function(){
            alert("Salvo com Sucesso");
            $(objTarget).load("/estoque/catProdutos/ajaxOptions/<?php echo $pai; ?>");
            loadDiv("#gridCategorias","/estoque/catProdutos/grid/<?php echo $pai; ?>");
        });
        
    });
</script>

<?php
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "created", "modified", "pai"))
                ->col("nome")->title("Nome")
                ->col("editar")->cell("editar.png","javascript:loadDiv('#formCategorias','/estoque/catProdutos/form/{pai}/{id}');")->title()
                ->col("deletar")->cell("deletar.png","javascript:delAjax('/estoque/catProdutos/deletar/{id}','gridCategorias','/estoque/catProdutos/grid/{pai}'); $(objTarget).load('/estoque/catProdutos/ajaxOptions/{pai}');")->title();

        break;
    case "form":
        echo $form->create("", array("id" => "formNovaCategoria", "class" => "formee"));
        echo $form->input("nome", array("label" => "Nome", "div" => "grid-12-12","value"=>$dadosForm["nome"]));
        echo $form->close("Salvar", array("class" => "formee-button grid-4-12"));
        break;
    case "cadastrar":
        echo $html->tag("script", "loadDiv('#formCategorias','/estoque/catProdutos/form/{$pai}');");
        echo $html->tag("script", "loadDiv('#gridCategorias','/estoque/catProdutos/lista/{$pai}');");
        echo $html->tag("div", "", array("class" => "grid-6-12", "id" => "formCategorias"));
        echo $html->tag("div", "", array("class" => "grid-6-12", "id" => "gridCategorias"));
        break;

    case "listar":
        echo $xgrid->start($dadosGrid);
        break;

    case "ajaxOptions":
        foreach ($dadosForm as $id => $nome) {
            if ($selecao > 0 and $selecao == $id) {
                $selecionado = "selected";
            }
            echo "<option value='{$id}' {$selecionado}> {$nome} </option>";
            $selecionado = "";
        }

        echo "<option value='Add'>Adicionar...</option>";
        break;
}
?>

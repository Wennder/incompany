<script>
    var obj;
    var objTarget;
    $(function(){
                
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        $("#abaProdutos").tabs();
        
        $("#buscaProduto").ajaxForm(function(){
            stateLoad("#contEstoque");
            $.post("/estoque/produtos/grid",$("#buscaProduto").serialize(), function(data){
                $("#contEstoque").html(data);
            });
        });
        
        $("#FormGrupoproduto").load("/estoque/catProdutos/ajaxOptions/0/<?php echo $dadosForm["grupoProduto"]; ?>");
        $("#FormTipoproduto").load("/estoque/catProdutos/ajaxOptions/<?php echo $dadosForm["grupoProduto"]; ?>/<?php echo $dadosForm["tipoProduto"]; ?>");
        $("#FormSegmentoproduto").load("/estoque/catProdutos/ajaxOptions/<?php echo $dadosForm["tipoProduto"]; ?>/<?php echo $dadosForm["segmentoProduto"]; ?>");
        $("#FormProcessoproduto").load("/estoque/catProdutos/ajaxOptions/<?php echo $dadosForm["segmentoProduto"]; ?>/<?php echo $dadosForm["processoProduto"]; ?>");
        
        $("#FormGrupoproduto").change(function(){
            obj = this;
            objTarget = this;
            if($(this).val()=='Add'){
                AbreJanela('/estoque/catProdutos/cadastrar/0', 500, 400, 'Adicionar Categoria de Produto', null, true);
                $(this).val(-1);
            }else{
                //$("#FormTipoproduto").load("/estoque/catProdutos/ajaxOptions/"+$("#FormGrupoproduto").val());
            }
        });
        
        $("#FormTipoproduto").change(function(){
            obj = this;
            objTarget = this;
            if($(this).val()=='Add'){
                AbreJanela('/estoque/catProdutos/cadastrar/'+$("#FormGrupoproduto").val(), 500, 400, 'Adicionar Categoria de Produto', null, true);
                $(this).val(-1);
            }else{
                //$("#FormSegmentoproduto").load("/estoque/catProdutos/ajaxOptions/"+$("#FormTipoproduto").val());
            }
            
        });
        
        $("#FormSegmentoproduto").change(function(){
            obj = $("#FormTipoproduto");
            objTarget = this;
            if($(this).val()=='Add'){
                AbreJanela('/estoque/catProdutos/cadastrar/'+$("#FormTipoproduto").val(), 500, 400, 'Adicionar Categoria de Produto', null, true);
                $(this).val(-1);
            }else{
                //$("#FormProcessoproduto").load("/estoque/catProdutos/ajaxOptions/"+$("#FormSegmentoproduto").val());
            }
        });
        
        $("#FormProcessoproduto").change(function(){
            obj = $("#FormSegmentoproduto");
            objTarget = this;
            
            if($(this).val()=='Add'){
                AbreJanela('/estoque/catProdutos/cadastrar/'+$("#FormSegmentoproduto").val(), 500, 400, 'Adicionar Categoria de Produto', null, true);
                $(this).val(-1);
            }
        });
        //loadDiv('#auxEstoque','/estoque/catProdutos/grid');
        
        $("#novoProduto").ajaxForm({
            success:function(){
            alert("Enviado com Sucesso");
            loadDiv("#auxEstoque","/estoque/produtos/buscar");
        },
        "target":"#contEstoque"
        
        });
        
        $("#FormTipoantidumping").change(function(){
            if($("#FormTipoantidumping").val()==1){
                $("#FormAliqantidumping").attr("alt","porcentagem");
                $("input:text").setMask();
                //alert("EU");
            }else{
                $("#FormAliqantidumping").attr("alt","moeda");
                $("input:text").setMask();
            }
        });
        
    });
</script>

<?php
$optAntidumping = array("Não Possui", "%CIF", "Valor Absoluto");
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Produtos")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "fabricantes_id", "fornecedor", "moedas_id", "moeda", "cod_ncm"))
                ->col("pNumber")->title("p/n")
                ->col("descricao")->title("Descrição")->slice(65)
                ->col("precoExterior")->title("EX $")
                ->col("preco")->title("R$")
                ->col("qtdAtual")->title("Estoque")
                ->col("editar")->title("")->cell("editar.gif", "javascript:loadDiv('#contEstoque','/estoque/produtos/cadastrar/{id}');")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/estoque/produtos/deletar/{id}','contEstoque','/estoque/produtos');");
        break;

    case "cadastrar":
        echo $form->create("", array("id" => "novoProduto", "class" => "formee"));
        echo $html->openTag("div", array("id" => "abaProdutos"));

        $menu = $html->Tag("li", $html->link("Cadastro", "#cadastro", null, false, true));
        //$menu .= $html->Tag("li", $html->link("Categorização", "#categorizacao", null, false, true));
        $menu .= $html->Tag("li", $html->link("Impostos", "#imposto", null, false, true));
        
        echo $html->tag("ul", $menu);

        echo $html->openTag("div", array("id" => "cadastro"));
        echo $form->input("origem", array("type" => "select", "label" => "Origem", "options" => array("Selecione", "Nacional", "Importado"), "div" => "grid-6-12", "value" => $dadosForm["origem"]));
        echo $form->input("pNumber", array("type" => "text", "label" => "Part Number", "div" => "grid-3-12", "value" => $dadosForm["pNumber"]));
        echo $form->input("ean", array("type" => "text", "label" => "EAN / GTIN", "alt" => "ean", "div" => "grid-3-12", "value" => $dadosForm["ean"]));
        echo $form->input("descricao", array("type" => "text", "label" => "Descrição", "div" => "grid-12-12", "value" => $dadosForm["descricao"]));
        echo $form->input("fabricantes_id", array("type" => "select", "options" => $listFornecedores, "label" => "Fornecedor", "div" => "grid-12-12", "value" => $dadosForm["fabricantes_id"]));

        echo $form->input("grupoProduto", array("type" => "select", "label" => "Grupo", "div" => "grid-3-12", "onChange" => "populaCombo('/estoque/catProdutos/ajaxOptions/'+this.value, '#FormTipoproduto', 'options');", "value" => $dadosForm["grupoProduto"]));
        echo $form->input("tipoProduto", array("type" => "select", "div" => "grid-3-12", "label" => "Tipo", "value" => $dadosForm["tipoProduto"], "onChange" => "populaCombo('/estoque/catProdutos/ajaxOptions/'+this.value, '#FormSegmentoproduto', 'options');"));
        echo $form->input("segmentoProduto", array("type" => "select", "div" => "grid-3-12", "label" => "Aplicação", "value" => $dadosForm["segmentoProduto"], "onChange" => "populaCombo('/estoque/catProdutos/ajaxOptions/'+this.value, '#FormProcessoproduto', 'options');"));
        echo $form->input("processoProduto", array("type" => "select", "label" => "Produto Final", "div" => "grid-3-12", "value" => $dadosForm["processoProduto"]));

        echo $form->input("qtdMinima", array("type" => "text", "alt" => "peso", "label" => "Qtd. Mímima", "div" => "grid-6-12", "value" => $dadosForm["qtdMinima"]));
        if ($dadosForm["id"] > 0) {
            $field = array("type" => "text", "alt" => "peso", "label" => "Qtd. Atual", "div" => "grid-6-12", "value" => $dadosForm["qtdAtual"], "disabled" => true);
        } else {
            $field = array("type" => "text", "alt" => "peso", "label" => "Qtd. Atual", "div" => "grid-6-12", "value" => $dadosForm["qtdAtual"]);
        }
        echo $form->input("qtdAtual", $field);

        echo $form->input("moedas_id", array("type" => "select", "options" => $listMoedas, "label" => "Moeda", "div" => "grid-3-12", "value" => $dadosForm["moedas_id"]));
        echo $form->input("precoExterior", array("label" => "Valor em M.E.", "alt" => "moedaProduto", "div" => "grid-3-12", "value" => $dadosForm["precoExterior"]));
        echo $form->input("preco", array("label" => "Valor em R$", "alt" => "moedaProduto", "div" => "grid-3-12", "value" => $dadosForm["preco"]));
        echo $form->input("peso", array("type" => "text", "alt" => "peso", "label" => "Peso", "div" => "grid-3-12", "value" => $dadosForm["peso"]));

        echo $html->closeTag("div");

        echo $html->openTag("div", array("id" => "imposto"));

        echo $html->openTag("div", array("class" => "container_12"));
        echo $html->openTag("fieldset", array("class" => "grid_12"));
        echo $html->tag("legend", "CST - Impostos");

        echo $form->input("ncm", array("type" => "text", "div" => "grid-2-12", "alt" => "ncm", "label" => "NCM", "value" => $dadosForm["ncm"]));
        echo $form->input("cti", array("type" => "text", "alt" => "cti-cst", "div" => "grid-2-12", "label" => "CTI", "class" => "FormMeioBloco", "value" => $dadosForm["cti"]));
        echo $form->input("cst", array("type" => "text", "alt" => "cti-cst", "label" => "CST ICMS", "div" => "grid-2-12", "value" => $dadosForm["cst"]));
        echo $form->input("cstIpi", array("type" => "text", "alt" => "cti-cst", "div" => "grid-2-12", "label" => "CST IPI", "value" => $dadosForm["cstIpi"]));
        echo $form->input("cstPis", array("type" => "text", "alt" => "cti-cst", "div" => "grid-2-12", "label" => "CST PIS", "value" => $dadosForm["cstPis"]));
        echo $form->input("cstCofins", array("type" => "text", "alt" => "cti-cst", "div" => "grid-2-12", "label" => "CST COFINS", "value" => $dadosForm["cstCofins"]));

        echo $form->input("tipoAntidumping", array("type" => "select", "options" => $optAntidumping, "div" => "grid-3-12", "label" => "Antidumping", "class" => "FormMeioBloco", "value" => $dadosForm["tipoAntidumping"]));
        echo $form->input("aliqAntidumping", array("type" => "text", "alt" => "cti-cst", "label" => "Aliq. Antidumping", "div" => "grid-3-12", "value" => $dadosForm["aliqAntidumping"]));
        echo $html->closeTag("fieldset");
        echo $html->closeTag("div");

        echo $html->closeTag("div");

        echo $html->closeTag("div");

        echo "<br clear='all' />";
        echo $form->close("Salvar", array("class" => "botao formee-button"));

        break;

    case "ajax":

        break;
    case "buscar":
        echo $html->tag("h3", "Buscar", array("class" => "title"));
        //Caixa de Busca de produtos
        echo $form->create("/estoque/produtos/grid", array("id" => "buscaProduto", "class" => "formee"));
        echo $form->input("descricao", array("type" => "text", "label" => "Descrição", "div" => "grid-12-12"));
        echo $form->input("ean", array("type" => "text", "label" => "EAN / GTIN", "alt" => "ean", "div" => "grid-6-12"));
        echo $form->input("limit", array("type" => "select", "options" => array("10" => "10", "20" => "20", "30" => "30", "40" => "40", "50" => "50"), "div" => "grid-6-12", "label" => "Registros"));
        
        echo $form->input("categoria1", array("type" => "select", "label" => "Grupo", "div" => "grid-12-12", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria2', 'options');", "options" => $dadosCat1));
        echo $form->input("categoria2", array("type" => "select", "div" => "grid-12-12", "label" => "Tipo", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria3', 'options');"));
        echo $form->input("categoria3", array("type" => "select", "div" => "grid-12-12", "label" => "Aplicação", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria4', 'options');"));
        echo $form->input("categoria4", array("type" => "select", "label" => "Produto Final", "div" => "grid-12-12"));
        
        echo $form->close("Buscar", array("class" => "botao grid-12-12"));
        echo "<br clear='all' />";
        break;
}
?>
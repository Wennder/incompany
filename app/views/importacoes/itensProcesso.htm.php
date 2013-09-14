<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#formProdutos").ajaxForm(function(){
            alert("Inserido com Sucesso!");
<?php
if ($tipoProcesso["tipoProcesso"] == 1) {
    echo "loadDiv('#gridProdutosImportacao','/importacoes/itensProcesso/grid/{$processo}/');";
} else {
    echo "loadDiv('#gridProdutosImportacao','/importacoes/itensProcesso/gridOrcamento/{$processo}/');";
}
?>
            
            loadDiv("#contFabricantes","/importacoes/fornecedoresProcesso/grid/<?php echo $processo ?>/");
            $("#formProdutos")[0].reset();
        });
        
        $("#formAliquotas").ajaxForm(function(){
            alert("Alterado com Sucesso!"); 
        });

        $('#adicoesProcesso').jCarouselLite({
            vertical: false,
            scroll: 1,
            auto:false,  
            speed:750,
            visible:1,
            circular:false,
            btnPrev:".adicaoAnterior",
            btnNext:".proximaAdicao"
        });

        
        $("#FormProdutoNome").autocomplete({
            minLength: 3,
            source: "/integracao/autocompleteProduto/",
            select: function(event, ui){
                $("#FormProdutoId").val(ui.item.id);
                $("#FormNcm").val(ui.item.ncm);
                $("#FormPeso").val(ui.item.peso);
                $("#FormPreco").val(ui.item.preco);
                $("#FormPrecoexterior").val(ui.item.precoExterior);
                $("#FormCti").val(ui.item.cti);
                $("#FormCst").val(ui.item.cst);
                
                $("#FormTipoantidumping").val(ui.item.tipoAntidumping);
                $("#FormAliqantidumping").val(ui.item.aliqAntidumping);
                if(ui.item.aliqii == null){
                    alert('NCM Não Cadastrado, Aliquotas poderão ser alteradas Manualmente.');
                }
                $("#FormAliqii").val(ui.item.aliqii);
                $("#FormAliqipi").val(ui.item.aliqipi);
                $("#FormAliqpis").val(ui.item.aliqpis);
                $("#FormAliqcofins").val(ui.item.aliqcofins);
                $("#FormAliqicmsst").val(ui.item.aliqicmsst);
                $("#FormCfop").val(ui.item.cfop);
            }
        }); 
            
    });
</script>
<?php
switch ($op) {
    default :
    case "grid":

        echo $html->openTag("div", array("style" => "float:left;height:270px;", "class" => "grid-2-12"));
        echo $html->tag("fieldset", "<legend>Adições</legend><center><h1>" . $importacoes->countAdicoes($dadosGrid[0]["processo"]) . "</h1></center>", array("style" => "height:80px;"));
        echo $html->tag("fieldset", "<legend>Produtos</legend><center><h1>" . count($dadosGrid) . "</h1></center>", array("style" => "height:80px;"));
        echo $html->tag("fieldset", "<legend>Valor</legend><center><h1 style='font-size:15px;'>" . $importacoes->fob($dadosGrid[0]["processo"], null, null, "processo", true) . "</h1></center>", array("style" => "height:80px;"));

        echo $html->closeTag("div");

        echo $html->openTag("div", array("style" => "float:right;", "class" => "grid-10-12"));

        $gridItens = $xgrid->start($dadosGrid)
                        ->alternate("grid_claro", "grid_escuro")
                        ->hidden(array("id", "produto_id", "preco", "created", "modified", "processo", "frete", "thc", "seguro", "taxaSiscomex", "despesasAduaneiras"))
                        ->col("estoque_produtos")->cellArray("pNumber")->title("p/n")->position(1)
                        ->col("ncm")->title("NCM")->position(3)
                        ->col("precoExterior")->title("FOB")->currency("$ ")
                        ->col("total")->position(9)->calcCurrency("{precoExterior}*{qtd}", "$")->title("Total")
                        ->col("editar")->title("")->cell("editar.png", "javascript:AbreJanela('/importacoes/itensProcesso/cadastrar/{processo}/{id}', 500, 300, 'Alteração de Produto', null, true);")
                        ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/itensProcesso/deletar/{id}','gridProdutosImportacao','/importacoes/itensProcesso/grid/{processo}/');");
        echo $html->tag("fieldset", "<legend>Produtos da Importação</legend><div style='overflow:auto; height:270px;' class='grid-12-12'>$gridItens</div>");
        echo $html->closeTag("div");
        break;
    case "gridOrcamento":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "produto_id", "preco", "created", "modified", "processo", "frete", "thc", "seguro", "taxaSiscomex", "despesasAduaneiras"))
                ->col("estoque_produtos")->cellArray("pNumber")->title("p/n")->position(1)
                ->col("ncm")->title("NCM")->position(3)
                ->col("precoExterior")->title("FOB")->currency("$ ")
                ->col("total")->position(9)->calcCurrency("{precoExterior}*{qtd}", "$")->title("Total")
                ->col("editar")->title("")->cell("editar.png", "javascript:AbreJanela('/importacoes/itensProcesso/cadastrar/{processo}/{id}', 500, 300, 'Alteração de Produto', null, true);")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/itensProcesso/deletar/{id}','gridProdutosImportacao','/importacoes/itensProcesso/gridOrcamento/{processo}/');");
        break;
    case "gridAdicoes":
        if (count($dadosForm) > 0) {
            echo $html->openTag("center");
            echo $html->tag("div", "<<", array("class" => "botao adicaoAnterior", "style" => "width:100px;"));
            echo $html->tag("div", ">>", array("class" => "botao proximaAdicao", "style" => "width:100px;"));
            echo $html->closeTag("center");

            echo $html->openTag("div", array("id" => "adicoesProcesso"));
            echo $html->openTag("ul", array("class" => "container_12"));
            $nAdicao = 0;
            foreach ($dadosForm as $adicao) {
                $nAdicao++;
                echo $html->openTag("li");
                echo $html->openTag("fieldset", array("class" => "grid_4"));
                echo $html->Tag("legend", "Adição " . $nAdicao);
                echo $form->input("nNcm", array("label" => "NCM", "disabled" => "1", "div" => "grid-12-12", "value" => $adicao["ncm"]));
                echo $form->input("pesoTotal", array("label" => "Peso da Adição", "disabled" => "1", "div" => "grid-12-12", "value" => $adicao["peso"]));
                echo $html->closeTag("fieldset");

                echo $html->openTag("fieldset", array("class" => "grid_4"));
                echo $html->Tag("legend", "Custos");
                echo $form->input("fobAdicao", array("label" => "FOB", "disabled" => "1", "div" => "grid-6-12", "value" => number_format($importacoes->fob($adicao["processo"], $adicao["ncm"], null, "adicao", false, true), 2)));
                echo $form->input("freteAdicao", array("label" => "Frete", "disabled" => "1", "div" => "grid-6-12", "value" => $adicao["frete"]));

                echo $form->input("seguroAdicao", array("label" => "Seguro", "disabled" => "1", "div" => "grid-4-12", "value" => $adicao["seguro"]));
                echo $form->input("thcAdicao", array("label" => "THC", "disabled" => "1", "div" => "grid-4-12", "value" => $adicao["thc"]));
                echo $form->input("taxaSiscomexAdicao", array("label" => "Siscomex", "disabled" => "1", "div" => "grid-4-12", "value" => $adicao["taxaSiscomex"]));

                echo $html->closeTag("fieldset");

                echo $html->openTag("fieldset", array("class" => "grid_4"));
                echo $html->Tag("legend", $html->link("Impostos Aduaneiros", "javascript:AbreJanela('/importacoes/itensProcesso/impostosAdicao/{$adicao["processo"]}/{$adicao["ncm"]}',450,280,'Resumo Tributação NCM {$adicao["ncm"]}',0,true);"));

                echo $form->input("iiAdicao", array("label" => "II", "disabled" => "1", "div" => "grid-6-12", "value" => $adicao["ii"]));
                echo $form->input("ipiAdicao", array("label" => "IPI", "disabled" => "1", "div" => "grid-6-12", "value" => $adicao["ipi"]));

                echo $form->input("pisCofinsAdicao", array("label" => "PIS + COFINS", "disabled" => "1", "div" => "grid-6-12", "value" => $adicao["pisCofins"]));
                echo $form->input("icmsAdicao", array("label" => "ICMS", "disabled" => "1", "div" => "grid-6-12", "value" => $adicao["icmsEntrada"]));

                echo $html->closeTag("fieldset");

                echo $html->tag("br", "", array("clear" => "all"), true);
                echo $html->tag("br", "", array("clear" => "all"), true);


//            $gridItens = $xgrid->start($importacoes->getItensAdicao($adicao["processo"], $adicao["ncm"]))
//                            ->caption("Produtos")
//                            ->alternate("grid_claro", "grid_escuro")
//                            ->hidden(array("id", "baseIcmsSt", "antiDumping", "aliqAntiDumping", "tipoAntiDumping", "icmsSt", "baseIcmsSaida", "icmsSaida", "produtoItem", "baseIcmsEntrada", "icmsEntrada", "aliqIcmsInterna", "aliqIcmsInterestadual", "aliqIcmsInternaPisCofins", "aliqIcmsSt", "preco", "precoExterior", "thc", "seguro", "pis", "cofins", "ipiSaida", "processo", "produto_id", "peso", "ncm", "taxaSiscomex", "aliqIi", "aliqIpi", "aliqPis", "aliqCofins", "aliqIcms", "icms", "icmsst", "cti", "cst", "created", "modified"))
//                            ->col("estoque_produtos")->cellArray("pNumber")->title("p/n")->position(0)
//                            ->col("qtd")->title("Qtde")
//                            ->col("frete")->calcCurrency("{frete}+{seguro}+{thc}")->title("Frete/Seguro")
//                            ->col("fob")->title("FOB")->currency("R$ ", 3)
//                            ->col("vUnitario")->title("V. Unitário")->calcCurrency("{fob}/{qtd}")->position(6)
//                            ->col("cif")->calcCurrency("({fob}+{frete}+{seguro}+{thc})")->title("CIF")->position(12)
//                            ->col("ii")->title("I.I.")->currency()
//                            ->col("ipiEntrada")->title("I.P.I.")->currency()
//                            ->col("produto")->calcCurrency("({fob}+{frete}+{seguro}+{thc})+{ii}")->title("Custo Estoque")
//                            ->col("despesasAduaneiras")->currency()->title("Desp. Locais");

                echo $html->tag("div", $gridItens, array("class" => "grid-12-12"));
                echo $html->closeTag("li");
            }
            echo $html->closeTag("ul");
            echo $html->closeTag("div");
        } else {
            echo $html->printWarning("Nenhum Produto Encontrado, caso tenha inserido produtos, efetue o recálculo.");
        }

        break;
    case "cadastrar":
        echo $form->create("", array("id" => "formProdutos", "class" => "formee"));
        echo $form->input("produto_nome", array("label" => "Produto", "div" => "grid-12-12", "value" => $dadosForm["estoque_produtos"]["descricao"]));
        echo $form->input("produto_id", array("type" => "hidden", "value" => $dadosForm["produto_id"]));
        echo $form->input("cfop", array("type" => "hidden", "value" => $dadosForm["cfop"]));
        echo $form->input("ncm", array("div" => "grid-6-12", "label" => "NCM", "alt" => "ncm", "value" => $dadosForm["ncm"]));
        echo $form->input("peso", array("div" => "grid-3-12", "alt" => "peso", "value" => $dadosForm["peso"]));
        echo $form->input("qtd", array("div" => "grid-3-12", "alt" => "qtd", "value" => $dadosForm["qtd"]));
        echo $form->input("preco", array("div" => "grid-6-12", "Valor em R$", "alt" => "moedaProduto", "value" => $dadosForm["preco"]));
        echo $form->input("precoExterior", array("div" => "grid-6-12", "label" => "Valor em M.E.", "alt" => "moedaProduto", "value" => $dadosForm["precoExterior"]));

        echo $form->input("cti", array("type" => "hidden", "value" => $dadosForm["cti"]));
        echo $form->input("cst", array("type" => "hidden", "value" => $dadosForm["cst"]));

        echo $form->input("tipoAntiDumping", array("type" => "hidden", "value" => $dadosForm["tipoAntiDumping"]));
        echo $form->input("aliqAntiDumping", array("type" => "hidden", "value" => $dadosForm["aliqAntiDumping"]));

        echo $form->input("aliqIi", array("type" => "hidden", "value" => $dadosForm["aliqIi"]));
        echo $form->input("aliqIpi", array("type" => "hidden", "value" => $dadosForm["aliqIpi"]));
        echo $form->input("aliqPis", array("type" => "hidden", "value" => $dadosForm["aliqPis"]));
        echo $form->input("aliqCofins", array("type" => "hidden", "value" => $dadosForm["aliqCofins"]));
        echo $form->input("aliqIcmsSt", array("type" => "hidden", "value" => $dadosForm["aliqIcmsSt"]));


        echo $form->close("Salvar", array("class" => "botao grid-4-12"));
        echo $html->link("Editar", "javascript:AbreJanela('/estoque/produtos/cadastrar/{$dadosForm["produto_id"]}', 500, 300, 'Alteração de Produto', null, true);", array("class" => "botao grid-4-12"));
        echo $html->link("Estoque", "javascript:AbreJanela('/estoque/produtos/cadastrar/', 500, 450, 'Inserir novo produto', null, true);", array("class" => "botao grid-4-12"));
        break;

    case "impostosAdicao":

        if (!empty($dadosEnviados)) {
            $importacoes->updateAdicao($dadosEnviados, $processo, $ncm);
        }
        echo $form->create("", array("id" => "formAliquotas", "class" => "formee"));
        echo $form->input("aliqIi", array("value" => $dadosForm["aliqIi"], "label" => "II (%)", "alt" => "porcentagem", "div" => "grid-3-12"));
        echo $form->input("aliqIpi", array("value" => $dadosForm["aliqIpi"], "label" => "IPI (%)", "alt" => "porcentagem", "div" => "grid-3-12"));
        echo $form->input("aliqPis", array("value" => $dadosForm["aliqPis"], "label" => "PIS (%)", "alt" => "porcentagem", "div" => "grid-3-12"));
        echo $form->input("aliqCofins", array("value" => $dadosForm["aliqCofins"], "label" => "COFINS (%)", "alt" => "porcentagem", "div" => "grid-3-12"));
        echo $form->input("aliqIcmsInterestadual", array("value" => $dadosForm["aliqIcmsInterestadual"], "label" => "ICMS Interestadual(%)", "alt" => "porcentagem", "div" => "grid-4-12"));
        echo $form->input("aliqIcmsInterna", array("value" => $dadosForm["aliqIcmsInterna"], "label" => "ICMS Interno(%)", "alt" => "porcentagem", "div" => "grid-4-12"));
        echo $form->input("aliqIcmsInternaPisCofins", array("value" => $dadosForm["aliqIcmsInternaPisCofins"], "label" => "B.C. Pis/Cofins (%)", "alt" => "porcentagem", "div" => "grid-4-12"));
        echo $form->input("aliqIcmsSt", array("value" => $dadosForm["aliqIcmsSt"], "label" => "ICMS ST (%)", "alt" => "porcentagem", "div" => "grid-6-12 clear"));
        echo $form->input("antiDumpingTotal", array("label" => "Antidumping (R$)", "div" => "grid-6-12", "alt" => "moedaProduto", "value" => $dadosForm["antiDumpingTotal"]));
        echo $form->input("pesoAdicao", array("label" => "Peso da Adicao (Kg)", "div" => "grid-6-12", "alt" => "peso", "value" => $dadosForm["pesoAdicao"]));
        echo $form->close("Salvar", array("class" => "botao grid-3-12"));
        break;
}
?>

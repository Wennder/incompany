<script>
    $(function(){
        $("#FormContatoId").load("/integracao/options/comercial_contatos/nome/<?php echo (empty($dadosForm["contato_id"])) ? "0" : $dadosForm["contato_id"]; ?>/id_cliente/"+<?php echo $dadosForm["cliente_id"]; ?>+"/");
        
        loadDiv("#gridProdutosImportacao","/importacoes/itensProcesso/gridOrcamento/<?php echo $dadosForm["processo"]; ?>/"); 
        loadDiv("#contAdicoes","/importacoes/itensProcesso/gridAdicoes/<?php echo $dadosForm["processo"]; ?>/");
        
        updateDespesasNacionalizacao();
        calculaCif();
        
        $('#graficoCustos').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Estatística de Importação'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Custos',
                    data: [
                        ['Mercadoria',   parseFloat($("#FormFob").val())],
                        ['Frete Internacional',       parseFloat($("#FormFrete").val())],
                        ['Impostos Alfandegários',    parseFloat($("#FormImpostos").val())],
                        ['Despesas Aduaneiras',     <?php echo $importacoes->sumProcesso($dadosForm["processo"], "sum(despesasAduaneiras)"); ?>]
                    ]
                }]
        });
        
        
    });
    
</script>

<?php
echo $html->script("controlaProcesso");
echo $html->script("/grafico/highcharts");
echo $html->script("/grafico/modules/exporting");

$processo = $dadosForm["processo"];
$tiposEmbarque = array(
    "Selecione...",
    "Rodoviário",
    "Marítimo",
    "Aéreo",
    "Ferroviário"
);

echo $form->create("", array("id"=>"formProcesso", "class" => "formee"));
echo $form->input("id", array("type" => "hidden", "value" => $dadosForm["id"]));
echo $form->input("IDPROCESSO", array("type" => "hidden", "value" => $dadosForm["processo"], "id" => "idProcesso"));
echo $html->openTag("div", array("class" => "container_16"));
echo $html->openTag("div", array("class" => "grid_10"));
echo $html->tag("h3", "1. Dados do Orçamento", array("class" => "title"));
//Dados Gerais
echo $form->input("IDprocesso", array("div" => "grid-2-12", "label" => "Processo", "disabled" => "true", "value" => $dadosForm["processo"]));
echo $form->input("descricaoProdutos", array("div" => "grid-6-12", "label" => "Descrição", "value" => $dadosForm["descricaoProdutos"]));
echo $form->input("operacao", array("type" => "select", "div" => "grid-4-12", "label" => "Tipo de Operação", "options" => $optOperacoes, "value" => $dadosForm["operacao"]["id"]));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("hr", "", array(), true);
//Cliente e Contato para o Orçamento
echo $form->input("nomeCliente", array("label" => "Cliente", "div" => "grid-8-12", "value" => $dadosForm["cliente"]["nomeFantasia"]));
echo $form->input("cliente_id", array("type" => "hidden", "value" => $dadosForm["cliente_id"]));
echo $form->input("contato_id", array("type" => "select", "label" => "Contato", "div" => "grid-4-12"));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("hr", "", array(), true);
//Dados de embarque
echo $form->input("tipoEmbarque", array("type" => "select", "label" => "Tipo de Embarque", "options" => $tiposEmbarque, "div" => "grid-4-12", "value" => $dadosForm["tipoEmbarque"]));
echo $form->input("origem", array("label" => "Origem", "div" => "grid-4-12", "value" => $dadosForm["origem"]));
echo $form->input("destino", array("label" => "Destino", "div" => "grid-4-12", "value" => $dadosForm["destino"]));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("hr", "", array(), true);
echo $form->input("enquadramento", array("type" => "select", "div" => "grid-3-12", "options" => array("Selecione...", "Simples Nacional", "Outros"), "value" => $dadosForm["enquadramento"]));
echo $form->input("industrial", array("type" => "select", "options" => $bool, "div" => "grid-2-12", "value" => $dadosForm["industrial"]));
echo $form->input("lucroReal", array("type" => "select", "label" => "Lucro Real", "options" => $bool, "div" => "grid-2-12", "value" => $dadosForm["lucroReal"]));
echo $form->input("destinacao", array("type" => "select", "label" => "Destinação", "div" => "grid-3-12", "options" => array("Selecione...", "Consumo", "Industrialização", "Comercialização"), "value" => $dadosForm["destinacao"]));
echo $form->input("desconto", array("alt" => "moeda", "div" => "grid-2-12", "label" => "Desconto", "value" => $dadosForm["desconto"]));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("br", "", array("clear" => "all"), true);
//Produtos do Orçamento
echo $html->tag("h3", "2. Produtos do Orçamento", array("class" => "title"));
echo $html->tag("div", $html->printWarning("Nenhum Produto"), array("id" => "gridProdutosImportacao", "class" => "container_16"));
echo $html->closeTag("div");
//Somatório dos Itens, Impostos, etc
echo $html->openTag("div", array("class" => "grid_6"));
//Memorial de Calculo
echo $html->tag("h3", "3. Memorial de Calculo", array("class" => "title"));
echo $form->input("moeda", array("type" => "select", "options" => $optMoedas, "div" => "grid-6-12", "label" => "Moeda", "value" => $dadosForm["moeda"]["id"]));
echo $form->input("txCambio", array("alt" => "moedaProduto", "div" => "grid-6-12", "label" => "Taxa de Câmbio", "value" => $dadosForm["txCambio"]));
echo $form->input("fob", array("alt" => "moeda", "disabled" => "1", "div" => "grid-6-12", "label" => "FOB (R$)", "value" => number_format($importacoes->fob($processo, null, null, "processo", false, true), 2, ".", "")));
echo $form->input("frete", array("alt" => "moeda", "onChange" => "calculaCif();", "div" => "grid-6-12", "label" => "Frete Internacional(R$)", "value" => $dadosForm["frete"]));
echo $form->input("seguro", array("alt" => "moeda", "onChange" => "calculaCif();", "div" => "grid-6-12", "label" => "Seguro (R$)", "value" => $importacoes->sumProcesso($processo, "format(sum(seguro),2)")));
echo $form->input("thc", array("alt" => "moeda", "onChange" => "calculaCif();", "div" => "grid-6-12", "label" => "THC(R$)", "value" => $dadosForm["thc"]));
echo $form->input("taxaSiscomex", array("alt" => "moeda", "div" => "grid-6-12", "label" => "Tx. Siscomex", "value" => $dadosForm["taxaSiscomex"]));
echo $form->input("cif", array("alt" => "moeda", "id" => "valorCif", "div" => "grid-6-12", "class" => "formee-error", "label" => "CIF", "value" => "", "disabled" => "1"));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("br", "", array("clear" => "all"), true);

//Impostos
echo $html->tag("h3", "4. Impostos Aduaneiros", array("class" => "title"));
echo $form->input("totalII", array("alt" => "moeda", "div" => "grid-6-12", "label" => "II", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(ii),2)")));
echo $form->input("totalIPI", array("alt" => "moeda", "div" => "grid-6-12", "label" => "IPI", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(ipiEntrada),2)")));
echo $form->input("totalPisCofins", array("alt" => "moeda", "div" => "grid-6-12", "label" => "PIS/COFINS", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(pis)+sum(cofins),2)")));
echo $form->input("totalICMS", array("alt" => "moeda", "div" => "grid-6-12", "label" => "ICMS", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(icmsEntrada),2)")));
echo $form->input("totalImpostos", array("alt" => "moeda", "id" => "FormImpostos", "div" => "grid-12-12", "class" => "formee-error", "label" => "Total", "value" => number_format($importacoes->sumProcesso($processo, "sum(ii)+sum(ipiEntrada)+sum(icmsEntrada)+sum(pis)+sum(cofins)"), 2, ",", ""), "disabled" => "1"));

echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("br", "", array("clear" => "all"), true);

//Despesas Aduaneiras
echo $html->tag("h3", "5. Despesas Aduaneiras", array("class" => "title"));
echo $html->tag("div", "Itens", array("id" => "qtdItens", "style" => "cursor:pointer;font-size:17px;font-weight:bold;", "class" => "grid-6-12", "onClick" => "AbreJanela('/importacoes/despesasNacionalizacao/cadastrar/$processo/', 500, 600, 'Despesas de Nacionalização', 0, true);"));
echo $html->tag("div", "R$ 0,00", array("id" => "somaItens", "style" => "font-size:17px;font-weight:bold;", "class" => "grid-6-12", "onClick" => "updateDespesasNacionalizacao();"));

echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("hr", "", array(), true);

if ($importacoes->sumProcesso($processo, "format(sum(produtoItem),2)") > 0) {
    echo $html->tag("div", "", array("id" => "graficoCustos", "style" => "height: 270px;"));
}

echo $html->closeTag("div");

echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("h3", "6. Adições", array("class" => "title"));
echo $html->tag("div", "", array("id" => "contAdicoes","class"=>"container_12"));

echo $html->closeTag("div");
echo $form->close(null);

?>

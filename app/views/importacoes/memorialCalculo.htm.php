<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#abaMemorial").tabs(); 
        
        updateDespesasNacionalizacao();
        calculaCif();
        
        loadDiv("#contAdicoes","/importacoes/itensProcesso/gridAdicoes/<?php echo $processo; ?>");
        $("a[href=#adicoes]").click(function(){
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
        });
    });
</script>
<?php
echo $html->openTag("div", array("id" => "abaMemorial"));
$menu = $html->Tag("li", $html->link("Geral", "#totalizadores", null, false, true));
$menu .= $html->Tag("li", $html->link("Adições", "#adicoes", null, false, true));
echo $html->tag("ul", $menu);


echo $html->openTag("div", array("id" => "totalizadores","class"=>"grid-12-12"));
echo $html->openTag("fieldset", array("class"=>"grid-4-12"));
echo $html->tag("legend", "Dados");
echo $form->input("despachante", array("div" => "grid-8-12", "label" => "Despachante", "value" => $dadosForm["despachante"]));
echo $form->input("refDespachante", array("div" => "grid-4-12", "label" => "Ref", "value" => $dadosForm["refDespachante"]));
echo $form->input("moeda", array("type" => "select", "options" => $optMoedas, "div" => "grid-6-12", "label" => "Moeda", "value" => $dadosForm["moeda"]["id"]));
echo $form->input("txCambio", array("alt" => "moedaProduto", "div" => "grid-6-12", "label" => "Taxa de Câmbio", "value" => $dadosForm["txCambio"]));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("hr", "", array(), true);
echo $html->tag("br", "", array("clear" => "all"), true);
echo $form->input("fob", array("alt" => "moeda", "disabled" => "1", "div" => "grid-6-12", "label" => "FOB (R$)", "value" => number_format($importacoes->fob($processo, null, null, "processo", false, true), 2, ".", "")));
echo $form->input("frete", array("alt" => "moeda", "onChange" => "calculaCif();", "div" => "grid-6-12", "label" => "Frete Internacional(R$)", "value" => $dadosForm["frete"]));
echo $form->input("seguro", array("alt" => "moeda", "onChange" => "calculaCif();", "div" => "grid-6-12", "label" => "Seguro (R$)", "value" => $importacoes->sumProcesso($processo, "format(sum(seguro),2)")));
echo $form->input("thc", array("alt" => "moeda", "onChange" => "calculaCif();", "div" => "grid-6-12", "label" => "THC(R$)", "value" => $dadosForm["thc"]));
echo $form->input("taxaSiscomex", array("alt" => "moeda", "div" => "grid-6-12", "label" => "Tx. Siscomex", "value" => $dadosForm["taxaSiscomex"]));

echo $form->input("cif", array("alt" => "moeda","id"=>"valorCif" ,"div" => "grid-6-12","class"=>"formee-error", "label" => "CIF", "value" => "", "disabled"=>"1"));

echo $html->closeTag("fieldset");

echo $html->openTag("fieldset", array("class"=>"grid-4-12"));
echo $html->tag("legend", "Impostos Aduaneiros");

echo $form->input("totalII", array("alt" => "moeda", "div" => "grid-6-12", "label" => "II", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(ii),2)")));
echo $form->input("totalIPI", array("alt" => "moeda", "div" => "grid-6-12", "label" => "IPI", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(ipiEntrada),2)")));
echo $form->input("totalPisCofins", array("alt" => "moeda", "div" => "grid-6-12", "label" => "PIS/COFINS", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(pis)+sum(cofins),2)")));
echo $form->input("totalICMS", array("alt" => "moeda", "div" => "grid-6-12", "label" => "ICMS", "disabled" => "1", "value" => $importacoes->sumProcesso($processo, "format(sum(icmsEntrada),2)")));
//echo $form->input("fator", array("alt" => "moeda","div"=>"Form100por", "label" => "Fator","disabled"=>"1"));
echo $form->input("totalImpostos", array("alt" => "moeda","id"=>"valorCif" ,"div" => "grid-12-12","class"=>"formee-error", "label" => "Total", "value" => number_format($importacoes->sumProcesso($processo, "sum(ii)+sum(ipiEntrada)+sum(icmsEntrada)+sum(pis)+sum(cofins)"), 2, ",",""), "disabled"=>"1"));

echo $html->closeTag("fieldset");


echo $html->openTag("fieldset", array("class"=>"grid-4-12"));
echo $html->tag("legend", "Despesas Locais");

echo $form->input("qtdContainer", array("alt" => "int", "label" => "Contêineres", "div" => "grid-6-12", "value" => $dadosForm["qtdContainer"]));
echo $form->input("qtdCarretas", array("alt" => "int", "label" => "Carretas", "div" => "grid-6-12", "value" => $dadosForm["qtdCarretas"]));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->tag("div", "Itens", array("id" => "qtdItens", "style" => "cursor:pointer;font-size:17px;font-weight:bold;","class"=>"grid-6-12", "onClick" => "AbreJanela('/importacoes/despesasNacionalizacao/cadastrar/$processo/', 500, 600, 'Despesas de Nacionalização', 0, true);"));
echo $html->tag("div", "R$ 0,00", array("id" => "somaItens", "style" => "font-size:17px;font-weight:bold;","class"=>"grid-6-12", "onClick" => "updateDespesasNacionalizacao();"));
echo $html->closeTag("fieldset");

echo $html->openTag("fieldset", array("class"=>"grid-4-12"));
echo $html->tag("legend", "Parâmetros");
echo $form->input("enquadramento", array("type" => "select", "div" => "grid-12-12", "options" => array("Selecione...", "Simples Nacional", "Outros"), "value" => $dadosForm["enquadramento"]));
echo $form->input("industrial", array("type" => "select", "options" => $bool, "div" => "grid-6-12", "value" => $dadosForm["industrial"]));
echo $form->input("lucroReal", array("type" => "select", "label" => "Lucro Real", "options" => $bool, "div" => "grid-6-12", "value" => $dadosForm["lucroReal"]));
echo $form->input("destinacao", array("type" => "select", "label" => "Destinação", "div" => "grid-6-12", "options" => array("Selecione...", "Consumo", "Industrialização", "Comercialização"), "value" => $dadosForm["destinacao"]));
echo $form->input("desconto", array("alt" => "moeda", "div" => "grid-6-12", "label" => "Desconto Comercial", "value" => $dadosForm["desconto"]));
echo $html->closeTag("fieldset");

echo $html->closeTag("div");

echo $html->Tag("div", $html->Tag("div", "", array("id" => "contAdicoes")), array("id" => "adicoes","class"=>"grid-12-12"));
echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->closeTag("div");
?>
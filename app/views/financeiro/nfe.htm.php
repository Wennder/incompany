<script>
    $(function(){
        $("input[alt=date]").datepicker({"dateFormat":"dd-mm-yy"});
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#formNfe").tabs();
        
        $("#FormNatope").autocomplete({
            source: "/integracao/autocompleteCfop/",
            minLength: 3,
            select: function(event, ui){
                $("#FormCustoId").val(ui.item.id);
            }
        });
        
        
    });
</script>
<?php
$this->pageTitle = "Financeiro :: NFe";
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
             ->caption("Notas Geradas")
            ->alternate("grid_claro","grid_escuro");
        break;

    case "entradaImportacao":
        echo $html->openTag("script");
        echo "loadDiv('#duplicatas','/financeiro/nfe/gridDuplicata');";
        echo $html->closeTag("script");
        echo $form->create("",array("class"=>"formee"));
        echo $html->openTag("div", array("id" => "formNfe"));
        
        $menu = $html->Tag("li", $html->link("1. Informações", "#ide", null, false, true));
        $menu .= $html->Tag("li", $html->link("2. Produtos", "#produtos", null, false, true));
        $menu .= $html->Tag("li", $html->link("3. Transporte", "#transporte", null, false, true));
        $menu .= $html->Tag("li", $html->link("4. Cobrança", "#cobranca", null, false, true));
        $menu .= $html->Tag("li", $html->link("5. Observações", "#obs", null, false, true));
        echo $html->tag("ul", $menu);

        echo $html->openTag("div", array("id" => "ide","class"=>"container_12"));
        
        echo $html->openTag("fieldset", array("class"=>"grid-6-12"));
        echo $html->tag("legend", "1.1 - Informações da Nota");
        echo $form->input("ide[nNf]", array("label" => "Número", "alt" => "inteiro", "div" => "grid-3-12"));
        echo $form->input("ide[dEmi]", array("label" => "Data de Emissão", "alt" => "date", "div" => "grid-3-12"));
        echo $form->input("ide[dSaiEnt]", array("label" => "Data Saída/Entrada", "alt" => "date", "div" => "grid-3-12"));
        echo $form->input("ide[hSaiEnt]", array("label" => "Hora Saída/Entrada", "alt" => "time", "div" => "grid-3-12"));
        echo $form->input("ide[cdNatOpe]", array("label" => "CFOP", "alt" => "cfop", "div" => "grid-3-12"));
        echo $form->input("ide[natOpe]", array("label" => "Natureza da Operação", "div" => "grid-9-12"));
        echo "<br clear='all'/>";
        echo $form->input("ide[ufOcorrencia]", array("type" => "select", "options" => $optionsEstados, "label" => "UF Ocorrência", "div" => "grid-3-12"));
        echo $form->input("ide[cMunFG]", array("type" => "select", "label" => "Município", "div" => "grid-9-12"));
        echo "<br clear='all'/>";
        echo "<hr />";
        echo $form->input("ide[tpNfe]", array("label" => "Tipo Documento", "type" => "select", "options" => array("Entrada", "Saída"), "div" => "grid-3-12"));
        echo $form->input("ide[indPag]", array("label" => "Pagamento", "type" => "select", "options" => array("À Vista", "À Prazo", "Outros"), "div" => "grid-3-12"));
        echo $form->input("ide[finNfe]", array("label" => "Finalidade", "type" => "select", "div" => "grid-3-12", "options" => array("1" => "Normal", "2" => "Complementar", "3" => "Ajuste")));
        echo $form->input("ide[tpImp]", array("label" => "Impressão", "type" => "select", "div" => "grid-3-12", "options" => array("1" => "Retrato", "2" => "Paisagem")));
        echo $html->closeTag("fieldset");

        echo $html->openTag("fieldset", array("class"=>"grid-6-12"));
        echo $html->tag("legend", "1.3 - Destinatário");
        echo $form->input("xNomeDest", array("label" => "Nome", "div" => "grid-12-12"));
        echo $form->input("CNPJDest", array("label" => "CNPJ", "alt" => "cnpj", "div" => "grid-6-12"));
        //echo $form->input("CPF",array("label"=>"CPF","alt"=>"cpf","div"=>"Form50por FormLeft"));
        echo $form->input("IEDest", array("label" => "IE", "div" => "grid-3-12"));
        echo $form->input("ISUF", array("label" => "I. SUFRAMA", "div" => "grid-3-12"));
        
        echo $form->input("eMailDest", array("label" => "Email", "div" => "grid-9-12"));
        //echo $form->input("CPF",array("label"=>"CPF","alt"=>"cpf","div"=>"Form50por FormLeft"));
        echo $form->input("foneDest", array("label" => "Fone","alt"=>"telefone", "div" => "grid-3-12"));
        echo "<br clear='all'/>";
        echo "<hr />";
        echo $form->input("xLgrDest", array("label" => "Endereço", "div" => "grid-12-12"));
        echo $form->input("nroDest", array("label" => "Nº", "div" => "grid-3-12"));
        echo $form->input("CEPDest", array("label" => "CEP","alt"=>"cep", "div" => "grid-3-12"));
        echo $form->input("xCplDest", array("label" => "Complemento", "div" => "grid-6-12"));
        echo $form->input("xBairroDest", array("label" => "Bairro", "div" => "grid-3-12"));
        echo $form->input("UFDest", array("type" => "select", "options" => $optionsEstados, "label" => "UF", "div" => "grid-3-12"));
        echo $form->input("cMunDest", array("type" => "select", "label" => "Município", "div" => "grid-6-12"));
        echo $html->link("XML", "javascript:AbreJanela('/importacoes/geraNotaEntrada/130108/0',600,400,'XML',0,true);", array("class" => "botao"));
        echo $html->closeTag("fieldset");

        echo $html->openTag("fieldset", array("class"=>"grid-6-12"));
        echo $html->tag("legend", "1.2 - Emitente");
        echo $form->input("RazaoSocialEmi", array("label" => "Razão Social", "div" => "grid-12-12"));
        echo $form->input("cnpjEmi", array("label" => "CNPJ", "div" => "grid-6-12"));
        echo $form->input("ieEmi", array("label" => "IE", "div" => "grid-3-12"));
        echo $form->input("imEmi", array("label" => "IM", "div" => "grid-3-12"));
        echo $form->input("xBairroEmi", array("label" => "Bairro", "div" => "grid-3-12"));
        echo $form->input("UFEmi", array("type" => "select", "options" => $optionsEstados, "label" => "UF", "div" => "grid-3-12"));
        echo $form->input("cMunEmi", array("type" => "select", "label" => "Município", "div" => "grid-6-12"));
        echo $html->closeTag("fieldset");



        echo "<br clear='all'/>";
        echo $html->closeTag("div");

        echo $html->openTag("div", array("id" => "produtos"));
        echo $html->closeTag("div");

        echo $html->openTag("div", array("id" => "cobranca"));
        echo $html->openTag("fieldset");
        echo $html->tag("legend", "4.1 - Fatura");

        echo $form->input("nFat", array("label" => "N. da fatura", "div" => "Form25por FormLeft"));
        echo $form->input("vOrig", array("label" => "V. Original", "alt" => "moeda", "div" => "Form25por FormLeft"));
        echo $form->input("vDesc", array("label" => "V. Desconto", "alt" => "moeda", "div" => "Form25por FormLeft"));
        echo $form->input("vLiq", array("label" => "V. Liquido", "alt" => "moeda", "div" => "Form25por FormRight"));

        echo $html->closeTag("fieldset");

        echo $html->openTag("fieldset");
        echo $html->tag("legend", "4.2 - Duplicatas");
        echo $html->tag("div", "", array("id" => "duplicatas"));
        echo $html->link("Incluir", "javascript:AbreJanela('/financeiro/nfe/novaDuplicata/',440,210,'Duplicatas',0,true);", array("class" => "botao"));
        echo $html->closeTag("fieldset");

        echo $html->closeTag("div");

        echo $html->openTag("div", array("id" => "transporte"));
        echo $html->openTag("fieldset",array("style" => "width:47%; height:250px; float:left;"));
        echo $html->tag("legend", "3.1 - Transportador");
        echo $form->input("modFrete",array("type"=>"select","label"=>"Modalidade de Frete","options"=>array("9"=>"Sem Frete","0"=>"Por Conta do Emitente","1"=>"Por Conta do Destinatário","2"=>"Por Conta de Terceiros"),"div"=>"Form100por"));
        echo $form->input("xNomeTransp", array("label" => "Razão Social", "div" => "Form100por"));
        echo $form->input("cnpjTransp", array("label" => "CNPJ", "div" => "Form50por FormLeft"));
        echo $form->input("ieTransp", array("label" => "IE", "div" => "Form50por FormRight"));
        echo $form->input("xEnderTransp", array("label" => "Bairro", "div" => "Form100por"));
        echo $form->input("UFTransp", array("type" => "select", "options" => $optionsEstados, "label" => "UF", "div" => "Form25por FormLeft"));
        echo $form->input("xMunTransp", array("type" => "select", "label" => "Município", "div" => "Form75por FormRight"));
        echo "<br clear='all'/>";
        echo "<hr />";
        echo $form->input("placaTransp",array("label"=>"Placa","alt"=>"placaVeiculo","div"=>"Form25por FormLeft"));
        echo $form->input("ufVeiculoTransp",array("type"=>"select","options"=>$optionsEstados,"label"=>"UF","div"=>"Form25por FormLeft"));
        echo $form->input("rntcTransp",array("label"=>"RNTC","div"=>"Form50por FormRight"));
        echo $html->closeTag("fieldset");

        echo $html->openTag("fieldset",array("style" => "width:47%; height:355px; float:right;"));
        echo $html->tag("legend", "3.3 - Volumes");
        echo $html->tag("div","",array("id"=>"volumesTransp","style"=>"height:305px"));
        echo $html->link("Incluir", "javascript:AbreJanela('/financeiro/nfe/novoVolume/',440,230,'Volumes - Incluir',0,true);", array("class" => "botao"));
        echo $html->closeTag("fieldset");

        echo $html->openTag("fieldset",array("style" => "width:47%; height:90px; float:left;"));
        echo $html->tag("legend", "3.2 - Retenção ICMS");
        
        echo $form->input("vServTransp",array("alt"=>"moeda","label"=>"Valor do Serviço","div"=>"Form25por FormLeft"));
        echo $form->input("vBCRetTransp",array("alt"=>"moeda","label"=>"BC ICMS","div"=>"Form25por FormLeft"));
        echo $form->input("pICMSRetTransp",array("alt"=>"porcentagem","label"=>"Aliquota ICMS","div"=>"Form25por FormLeft"));
        echo $form->input("vICMSRetTransp",array("alt"=>"moeda","label"=>"ICMS Retido","div"=>"Form25por FormRight"));
        
        echo $form->input("cfopTransp",array("type"=>"select","label"=>"CFOP","div"=>"Form25por FormLeft"));
        echo $form->input("UFFGTransp",array("type"=>"select","options"=>$optionsEstados,"label"=>"UF","div"=>"Form25por FormLeft"));
        echo $form->input("cMunFGTransp", array("type" => "select", "label" => "Município", "div" => "Form50por FormRight"));
        echo $html->closeTag("fieldset");
        
        echo "<br clear='all'/>";
        echo $html->closeTag("div");

        echo $html->openTag("div", array("id" => "obs"));
        echo $html->closeTag("div");

        
        echo $form->close("Salvar");
        echo $html->closeTag("div");
        break;

    case "saidaImportacao":
        break;

    case "nova":
        break;

    case "cancelar":
        break;

    case "produtosNota":
        break;
    case "novoVolume":
        echo $form->create();
        echo $form->input("qvol",array("alt"=>"intsemponto","label"=>"Quantidade","div"=>"Form25por FormLeft"));
        echo $form->input("esp",array("label"=>"Espécie (Caixas,Sacos...) ","div"=>"Form75por FormRight"));
        echo $form->input("marca",array("div"=>"Form50por FormLeft"));
        echo $form->input("nVol",array("label"=>"Numeração","div"=>"Form50por FormLeft"));
        echo $form->input("pesoL",array("label"=>"Peso Liquido","alt"=>"peso","div"=>"Form50por FormLeft"));
        echo $form->input("pesoB",array("label"=>"Peso Bruto","alt"=>"peso","div"=>"Form50por FormRight"));
        echo $form->input("lacres",array("label"=>"Lacres (Separar por virgulas)","div"=>"Form100por FormLeft"));
        echo $form->close("Salvar", array("class" => "botao"));
        break;
    case "gridVolumes":
        echo $xgrid->start($dadosGrid)
            ->caption("Volumes da Nota Fiscal")
            ->alternate("grid_claro","grid_escuro");
        break;
    case "novaDuplicata":
        echo $form->create("");
        echo $form->input("numero", array("label" => "Número", "div" => "Form100por"));
        echo $form->input("vencimento", array("alt" => "date", "div" => "Form50por FormLeft"));
        echo $form->input("valor", array("alt" => "moeda", "div" => "Form50por FormRight"));
        echo $form->close("Salvar", array("class" => "botao"));
        break;
    case "gridDuplicata":
        echo $xgrid->start($dadosGrid)
                ->caption("Duplicatas da NFe")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "created", "modified", "cliente_id", "nf", "obs"));
        break;

    case "getXml":
        
        break;
}
?>

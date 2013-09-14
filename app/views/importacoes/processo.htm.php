<script>
    $(function(){
        $.ajaxSetup ({
            cache: false
        });
        $("input[alt=date]").datepicker({"dateFormat":"dd-mm-yy"});
        $("#FormContatoId").load("/integracao/options/comercial_contatos/nome/<?php echo (empty($dadosForm["contato_id"])) ? "0" : $dadosForm["contato_id"]; ?>/id_cliente/"+<?php echo $dadosForm["cliente_id"]; ?>+"/");
        $("#FormAgentecarga").load("/integracao/agenteCarga/<?php echo $dadosForm["agenteCarga"]; ?>");
        loadDiv("#contFabricantes","/importacoes/fornecedoresProcesso/grid/<?php echo $dadosForm["processo"]; ?>");
        loadDiv("#gridAnexos","/importacoes/uploadDocumento/grid/<?php echo $dadosForm["processo"]; ?>/");
        loadDiv("#gridConteineres","/importacoes/conteineres/grid/<?php echo $dadosForm["processo"]; ?>/");
        loadDiv("#contContratosCambio","/importacoes/contratosCambio/grid/<?php echo $dadosForm["processo"]; ?>");
        loadDiv("#contCustosFechamento","/importacoes/custosFechamento/grid/<?php echo $dadosForm["processo"]; ?>");
        loadDiv("#contMemorialCalculo","/importacoes/memorialCalculo/<?php echo $dadosForm["processo"]; ?>");
        loadDiv("#gridProdutosImportacao","/importacoes/itensProcesso/grid/<?php echo $dadosForm["processo"]; ?>/");
        
        $("#abaDocumentos").tabs(); 
       
<?php
if ($dadosForm["tipoProcesso"] == "1") {
    echo "lockTornarPedido();";
} else {
    //Dando erro no desabilitar das abas
    //echo "$('#abaProcesso').tabs('disable',3);";
    //echo "$('#abaProcesso').tabs('disable',1);";
}
?>
    });
</script>
<?php
$optIncoterms = array(
    "Selecione...", "CFR", "CIF", "CIP", "CPT", "DAF", "DDP", "DDU", "DEQ", "DES", "EXW", "FAS", "FCA", "FOB"
);
$tiposEmbarque = array(
    "Selecione...",
    "Rodoviário",
    "Marítimo",
    "Aéreo",
    "Ferroviário"
);
$this->pageTitle = "Importações :: {$tipoProcesso[$dadosForm["tipoProcesso"]]} {$dadosForm["processo"]}";

$this->avisoRodape = "Ultima Alteração: {$date->format("d/m/Y H:i:s", $dadosForm["modified"])} por {$dadosForm["who"]}";
//definição de variáveis

echo $form->create("", array("id" => "formProcesso", "class" => "formee"));
echo $form->input("id", array("type" => "hidden", "value" => $dadosForm["id"]));
echo $html->openTag("div", array("id" => "abaProcesso"));

$menu = $html->Tag("li", $html->link("Dados Gerais", "#dadosGerais", null, false, true));
$menu .= $html->Tag("li", $html->link("Embarque", "#documentos", null, false, true));
$menu .= $html->Tag("li", $html->link("Produtos", "#produtos", null, false, true));
$menu .= $html->Tag("li", $html->link("Financeiro", "#financeiro", null, false, true));
$menu .= $html->Tag("li", $html->link("Memorial de Cálculo", "#memorial", null, false, true));
$menu .= $html->Tag("div", "<b>" . $dadosForm["processo"] . "</b>", array("style" => "float:right; margin-top:5px; margin-right:5px; font-size:18px;"));
echo $html->tag("ul", $menu);

//aba1
echo $html->openTag("div", array("id" => "dadosGerais", "class" => "container_16"));

echo $html->openTag("fieldset", array("class" => "grid_16"));
echo $html->tag("legend", "Dados");
echo $form->input("IDPROCESSO", array("type" => "hidden", "value" => $dadosForm["processo"], "id" => "idProcesso"));

echo $form->input("descricaoProdutos", array("div" => "grid-12-12", "label" => "Descrição", "value" => $dadosForm["descricaoProdutos"]));
echo $form->input("operacao", array("type" => "select", "div" => "grid-6-12", "label" => "Tipo de Operação", "options" => $optOperacoes, "value" => $dadosForm["operacao"]["id"]));
echo $form->input("status_id", array("type" => "select", "div" => "grid-6-12", "label" => "Status do Processo", "options" => $optStatus, "value" => $dadosForm["status_id"]));
echo $html->closeTag("fieldset");

echo $html->openTag("fieldset", array("id" => "boxCliente", "class" => "grid_8"));
echo $html->tag("legend", "Cliente");
echo $form->input("nomeCliente", array("label" => "Cliente", "div" => "grid-12-12", "value" => $dadosForm["cliente"]["nomeFantasia"]));
echo $form->input("cliente_id", array("type" => "hidden", "value" => $dadosForm["cliente_id"]));
echo $form->input("contato_id", array("type" => "select", "label" => "Contato", "div" => "grid-12-12"));

echo $form->input("dtPedidoCliente", array("alt" => "date", "label" => "Data Pedido", "div" => "grid-3-12", "value" => $date->format("d-m-Y", $dadosForm["dtPedidoCliente"])));
echo $form->input("confCliente", array("type" => "select", "options" => array("No Aguardo", "Confirmado"), "label" => "Status ", "div" => "grid-3-12", "value" => $dadosForm["confCliente"]));
echo $form->input("nConfCliente", array("label" => "Número do Pedido", "div" => "grid-6-12", "value" => $dadosForm["nConfCliente"]));
echo $html->closeTag("fieldset");

echo $html->openTag("fieldset", array("id" => "boxFabricantes", "style" => "height:208px;", "class" => "grid_8"));
echo $html->tag("legend", "Fabricante");

echo $html->tag("div", "", array("id" => "contFabricantes", "style" => "overflow:auto;", "class" => "grid-12-12"));
echo $html->closeTag("fieldset");

echo $html->tag("br", "", array("clear" => "all"), true);

echo $html->closeTag("div");
//fim aba1
//Aba 2
echo $html->openTag("div", array("id" => "documentos"));

echo $html->openTag("div", array("id" => "abaDocumentos"));
$menu = $html->Tag("li", $html->link("Geral", "#embarque", null, false, true));
$menu .= $html->Tag("li", $html->link("Documentos", "#anexos", null, false, true));
echo $html->tag("ul", $menu);

echo $html->openTag("div", array("id" => "embarque", "class" => "grid-12-12"));
echo $html->openTag("fieldset", array("class" => "grid-6-12"));
echo $html->tag("legend", "Embarque");

echo $form->input("tipoEmbarque", array("type" => "select", "label" => "Tipo de Embarque", "options" => $tiposEmbarque, "div" => "grid-6-12", "value" => $dadosForm["tipoEmbarque"]));
echo $form->input("agenteCarga", array("type" => "select", "label" => "Agente de Carga", "options" => array("Selecione..."), "div" => "grid-6-12", "value" => $dadosForm["agenteCarga"]));
echo $form->input("incoterm", array("type" => "select", "label" => "Incoterms", "options" => $optIncoterms, "div" => "grid-6-12", "value" => $dadosForm["incoterm"]));
echo $form->input("embarcado", array("type" => "select", "options" => $bool, "div" => "grid-6-12", "value" => $dadosForm["embarcado"]));

echo $form->input("origem", array("label" => "Origem", "div" => "grid-6-12", "value" => $dadosForm["origem"]));
echo $form->input("destino", array("label" => "Destino", "div" => "grid-6-12", "value" => $dadosForm["destino"]));

echo $form->input("etd", array("alt" => "date", "label" => "ETD", "div" => "grid-6-12", "value" => $date->format("d-m-Y", $dadosForm["etd"])));
echo $form->input("eta", array("alt" => "date", "label" => "ETA", "div" => "grid-6-12", "value" => $date->format("d-m-Y", $dadosForm["eta"])));

echo $form->input("nMaster", array("label" => "Master", "div" => "grid-4-12", "value" => $dadosForm["nMaster"]));
echo $form->input("nHouse", array("label" => "House", "div" => "grid-4-12", "value" => $dadosForm["nHouse"]));
echo $form->input("codRastreio", array("label" => "Booking", "div" => "grid-4-12", "value" => $dadosForm["codRastreio"]));

echo $form->input("trackingStatus", array("label" => "Status Embarque", "div" => "grid-12-12", "disabled" => true, "value" => $dadosForm["trackingStatus"]));

echo $html->closeTag("fieldset");

echo $html->openTag("fieldset", array("style" => "height:322px;", "class" => "grid-6-12"));
echo $html->tag("legend", "Contêineres");
echo $html->tag("div", "", array("id" => "gridConteineres", "style" => "overflow:auto;height:300px;", "class" => "grid-12-12"));
echo $html->closeTag("fieldset");

echo $html->closeTag("div");

echo $html->openTag("div", array("id" => "anexos", "class" => "grid-12-12"));
echo $html->openTag("fieldset", array("style" => "height:290px;"));
echo $html->tag("legend", "Arquivos");
echo $html->link("Adicionar", "javascript:AbreJanela('/importacoes/uploadDocumento/cadastrar/{$dadosForm["processo"]}',440,275,'Documentos - Anexos',0,true);", array("div" => "grid-2-12", "class" => "botao formee-button"));
echo $html->tag("div", "", array("id" => "gridAnexos", "class" => "grid-12-12"));
echo $html->closeTag("fieldset");
echo $html->closeTag("div");

echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->closeTag("div");



echo $html->tag("br", "", array("clear" => "all"), true);
echo $html->closeTag("div");
//Fim Aba 2
//Aba 3
echo $html->openTag("div", array("id" => "produtos"));

echo $html->tag("div", "", array("id" => "gridProdutosImportacao"));
echo $html->tag("br", "", array("clear" => "all"), true);

echo $html->closeTag("div");
//Fim Aba 3
//Aba 4
echo $html->openTag("div", array("id" => "financeiro", "class" => "grid-12-12"));


echo $html->openTag("fieldset", array("style" => "height:300px;", "class" => "grid-6-12"));
echo $html->tag("legend", "Custos de Fechamento");
echo $html->tag("div", "", array("id" => "contCustosFechamento", "style" => "overflow:auto; height:275px;", "class" => "grid-12-12"));
echo $html->closeTag("fieldset");

echo $html->openTag("fieldset", array("style" => "height:133px;", "class" => "grid-6-12"));
echo $html->tag("legend", "Contratos de Câmbio");
echo $html->tag("div", "", array("id" => "contContratosCambio", "style" => "overflow:auto;", "class" => "grid-12-12"));
echo $html->closeTag("fieldset");

echo $html->openTag("fieldset", array("style" => "height:133px;", "class" => "grid-6-12"));
echo $html->tag("legend", "Notas Fiscais");

echo $html->closeTag("fieldset");
echo "<br clear='all' />";
echo $html->closeTag("div");
//Fim Aba 4
//Aba 5
echo $html->openTag("div", array("id" => "memorial"));
echo $html->tag("div", "", array("id" => "contMemorialCalculo"));
echo $html->closeTag("div");
//Fim Aba 5
echo $html->closeTag("div");
echo $form->closeTag("form");

echo $html->script("controlaProcesso");
?>
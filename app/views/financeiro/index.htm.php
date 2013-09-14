<?php

$this->pageTitle = "Financeiro :: Home";

//Título
echo $html->openTag("h3");
echo "Reembolsos";
echo $html->closeTag("h3");
//Botões
echo $html->link("Verificar", "/financeiro/reembolsos/", array("class" => "botao"));
echo $html->link("Lista Aprovação", "/financeiro/relDespesaReembolso/", array("class" => "botao"));
echo $html->link("Imprimir Lote de Pagamento", "javascript:AbreJanela('/financeiro/relatorios/selecionaDataLoteReembolso', 300,300,'Selecione o dia para Impressão do Lote');", array("class" => "botao"));
echo $html->link("Gráfico Anual", "/financeiro/relatorios/movimentoReembolso", array("class" => "botao"));
echo "<br />";
echo "<br />";

//Título
echo $html->openTag("h3");
echo "Boletos de Cobrança";
echo $html->closeTag("h3");
//Botões
echo $html->link("Novo Boleto", "javascript:popIn('janelaModal','/financeiro/receber/novaCobranca');", array("class" => "botao"));
echo $html->link("Listar Todos", "/financeiro/receber/gridCobranca", array("class" => "botao"));
echo $html->link("Buscar", "javascript:AbreJanela('/financeiro/receber/buscaCobranca', 500,200, 'Buscar Cobranças Realizadas');", array("class" => "botao"));
echo $html->link("Inadimplentes", "/financeiro/receber/cobrancasAtrasadas", array("class" => "botao"));
echo $html->link("Processar Pagamento", "javascript:AbreJanela('/financeiro/receber/processaPagamentoBoletos',500,200,'Processar Pagamento de Boletos');", array("class" => "botao"));
echo "<br />";
echo "<br />";

//Título
echo $html->openTag("h3");
echo "Configurações do Módulo";
echo $html->closeTag("h3");
//Botões
echo $html->link("Bancos", "/financeiro/bancos/", array("class" => "botao"));
echo $html->link("Conf. Boletos", "/financeiro/configBoleto/", array("class" => "botao"));
echo $html->link("Tipos de Despesas", "/financeiro/tipoDespesa/", array("class" => "botao"));
echo $html->link("Motivos de Despesa", "/financeiro/motivoDespesa/", array("class" => "botao"));
echo "<br />";
echo "<br />";
?>
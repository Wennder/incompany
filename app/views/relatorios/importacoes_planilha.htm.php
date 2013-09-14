<?php

$pdf->SetMargins(10, 10);

//define a fonte a ser usada
$pdf->SetFont('Times', '', 10);

//define o titulo
$pdf->SetTitle($processo["operacao"]["nomeOperacao"]);

//assunto
$pdf->SetSubject("Planilha de Custos de Importação");

// posicao vertical  caso -1.. e o limite da margem
$pdf->SetY("-1");


$destinacoes = array("0" => "Selecione...", "1" => "Consumo", "2" => "Industrialização", "3" => "Comercialização");

$tiposEmbarque = array(
    "Selecione...",
    "Rodoviário",
    "Marítimo",
    "Aéreo",
    "Ferroviário"
);

$totalImpostosEntrada = array();
$totalImpostosSaida = array();

//==================== Dados do Cliente ===========
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0, 5, 'Processo: ' . $processo["processo"], 0, 1, L);
$pdf->SetFont('Times', '', 10);

$pdf->Cell(0, 5, 'Cliente: ' . $processo["cliente"]["nomeFantasia"] . " ( " . $processo["cliente"]["razaoSocial"] . " )", 0, 1, L);
$pdf->Cell(73, 5, 'Contato: ' . $processo["contato"]["nome"], 0, 0, L);
$pdf->Cell(60, 5, 'Email: ' . $processo["contato"]["email"], 0, 0, L);
if (empty($processo["contato"]["tel1"])) {
    $TelContato = $processo["cliente"]["telefone"];
} else {
    $TelContato = $processo["contato"]["tel1"];
}
$pdf->Cell(57, 5, 'Telefone: ' . $TelContato, 0, 1, "R");
$pdf->Cell(73, 5, 'Localização: ' . $processo["cliente"]["municipio"]["nome"] . " - " . $optionsEstados[$processo["cliente"]["estado_id"]], 0, 0, L);
$pdf->Cell(60, 5, 'Destinação: ' . $destinacoes[$processo["destinacao"]], 0, 1, L);
$pdf->Ln(3);

//==================== Dados da Carga ===========
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(0, 5, 'Dados da Carga', 0, 1, 'L');
$pdf->Cell(0, 0, '', 1, 1, 'L');
$pdf->Cell(0, 3, '', 0, 1, 'L');
$pdf->SetFont('Times', '', 9);

$pdf->Cell(85, 4, 'Produto: ' . $processo["descricaoProdutos"], 0, 0, 'L');
$pdf->Cell(20, 4, 'Total Ctr: ', 0, 0, 'R');
$pdf->Cell(10, 4, $processo["qtdContainer"], 0, 0, 'L');

$pdf->Cell(20, 4, 'Origem', 0, 0, 'L');
$pdf->Cell(55, 4, $processo["origem"], 0, 1, 'R');

$fobProcessoME = $importacoes->fob($processo["processo"], null, null, "processo", false, false);

$pdf->Cell(85, 4, 'FOB: ' . $importacoes->formatMoeda($importacoes->cambio($processo["processo"], $fobProcessoME), "R$ "), 0, 0, 'L');
$pdf->Cell(20, 4, 'Qtde. de Carretas: ', 0, 0, 'R');
$pdf->Cell(10, 4, $processo["qtdCarretas"], 0, 0, 'L');

$pdf->Cell(20, 4, 'Destino Final', 0, 0, 'L');
$pdf->Cell(55, 4, $processo["destino"], 0, 1, 'R');

$pdf->Cell(75, 4, 'Tx. de Câmbio: R$ ' . $processo["txCambio"], 0, 0, 'L');
$pdf->Cell(40, 4, '', 0, 0, 'R');

//Tipo de embarque
$pdf->Cell(20, 4, 'Modalidade', 0, 0, 'L');
$pdf->Cell(55, 4, $tiposEmbarque[$processo["tipoEmbarque"]], 0, 1, 'R');

$pdf->Ln(3);

//=================== Custos da Importaao =======
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(90, 5, 'Custos da Importação', 0, 0, 'L');
$pdf->Cell(10, 5, '', 0, 0, 'L');
$pdf->Cell(90, 5, 'Impostos Alfandegários', 0, 1, 'L');

$pdf->Cell(90, 0, '', 1, 0, 'L');
$pdf->Cell(10, 0, '', 0, 0, 'L');
$pdf->Cell(90, 0, '', 1, 1, 'L');

$pdf->SetFont('Times', '', 8);

$pdf->Ln(3);
//FOB
$pdf->Cell(40, 4, 'FOB', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($fobProcessoME, false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($fobProcessoME * $processo["txCambio"], false), 0, 0, 'R');
//espao
$pdf->Cell(10, 4, '', 0, 0, 'L');
//Imposto de Importaao
$totalImpostosEntrada["ii"] = $importacoes->sumProcesso($processo["processo"], "sum(ii)");
$pdf->Cell(40, 4, 'Imposto de Importação', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["ii"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["ii"], false), 0, 1, 'R');
//Frete
$pdf->Cell(40, 4, 'Frete Internacional', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($processo["frete"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($processo["frete"], false), 0, 0, 'R');
//espaço
$pdf->Cell(10, 0, '', 0, 0, 'L');
//IPI
$totalImpostosEntrada["ipi"] = $importacoes->sumProcesso($processo["processo"], "sum(ipiEntrada)");
$pdf->Cell(40, 4, 'IPI', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["ipi"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["ipi"], false), 0, 1, 'R');
//THC
$pdf->Cell(40, 4, 'THC', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($processo["thc"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($processo["thc"], false), 0, 0, 'R');
//espao
$pdf->Cell(10, 0, '', 0, 0, 'L');
//PIS
$totalImpostosEntrada["pis"] = $importacoes->sumProcesso($processo["processo"], "sum(pis)");
$pdf->Cell(40, 4, 'PIS', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["pis"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["pis"], false), 0, 1, 'R');

//Seguro Internacional
$pdf->Cell(40, 4, 'Seguro Internacional', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($processo["seguro"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($processo["seguro"], false), 0, 0, 'R');
//espao
$pdf->Cell(10, 0, '', 0, 0, 'L');
//Cofins
$totalImpostosEntrada["cofins"] = $importacoes->sumProcesso($processo["processo"], "sum(cofins)");
$pdf->Cell(40, 4, 'Cofins', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["cofins"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($totalImpostosEntrada["cofins"], false), 0, 1, 'R');

//CIF
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(40, 4, 'CIF', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$cifProcesso = ($fobProcessoME * $processo["txCambio"]) + $processo["frete"] + $processo["seguro"] + $processo["thc"];
$pdf->Cell(15, 4, $importacoes->formatMoeda($cifProcesso / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda($cifProcesso, false), 0, 0, 'R');
//Espaço
$pdf->Cell(10, 0, '', 0, 0, 'L');
//Em Branco
$pdf->Cell(40, 4, '', 0, 0, 'L');
$pdf->Cell(10, 4, $processo["moeda"]["simbolo"], 0, 0, "L");
$pdf->Cell(15, 4, $importacoes->formatMoeda(array_sum($totalImpostosEntrada) / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 4, 'R$', 0, 0, 'R');
$pdf->Cell(15, 4, $importacoes->formatMoeda(array_sum($totalImpostosEntrada), false), 0, 1, 'R');
$pdf->Ln(3);

//Titulo Despesas
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(0, 5, 'Despesas de Nacionalização (Previsão)', 0, 1, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(0, 0, '', 1, 1, 'L');
$pdf->Ln(1);

//Despenas de nacionalização
foreach ($despesasNacionalizacao as $despesa) {
    $pdf->Cell(110, 3, (!empty($despesa["custo"]["nome"])) ? $despesa["custo"]["nome"] : "Despesas Diversas", 0, 0, 'L');
    $pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
    $pdf->Cell(20, 3, $importacoes->formatMoeda(($despesa["valorTotal"] / $processo["txCambio"]), false), 0, 0, 'R');

    $pdf->Cell(20, 3, 'R$', 0, 0, 'R');
    $pdf->Cell(20, 3, $importacoes->formatMoeda($despesa["valorTotal"], false), 0, 1, 'R');
    $totalDespesas = $totalDespesas + $despesa["valorTotal"];
}
$pdf->Cell(110, 3, "Tx. Siscomex", 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda(($processo["taxaSiscomex"] / $processo["txCambio"]), false), 0, 0, 'R');

$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($processo["taxaSiscomex"], false), 0, 1, 'R');

$totalDespesas = $totalDespesas + $processo["taxaSiscomex"];

//Imprime a SOMA das despesas aduaneiras
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(110, 4, 'Total das Despesas Aduaneiras', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalDespesas / $processo["txCambio"], false), 0, 0, 'R');

$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalDespesas, false), 0, 1, 'R');
$pdf->Ln(3);

//BLOCO Formação NF
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(0, 5, 'Formação da NF a partir do Custo da Mercadoria Importada', 0, 1, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(0, 0, '', 1, 1, 'L');
$pdf->Ln(1);

$totalImpostosSaida["baseIcms"] = $importacoes->sumProcesso($processo["processo"], "sum(baseIcmsSaida)");

$pdf->Cell(110, 3, 'Base de Cálculo', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["baseIcms"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["baseIcms"], false), 0, 1, 'R');

$totalImpostosSaida["icms"] = $importacoes->sumProcesso($processo["processo"], "sum(icmsSaida)");
$pdf->Cell(110, 3, 'Total ICMS', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["icms"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 3, '', 0, 0, 'L');
$pdf->Cell(10, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["icms"], false), 0, 1, 'R');

//Icms Substituição tributária
$totalImpostosSaida["icmsSt"] = $importacoes->sumProcesso($processo["processo"], "sum(icmsSt)");
$pdf->Cell(110, 3, 'Total ICMS ST', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["icmsSt"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 3, '', 0, 0, 'L');
$pdf->Cell(10, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["icmsSt"], false), 0, 1, 'R');

$totalImpostosSaida["produtoProcesso"] = $importacoes->sumProcesso($processo["processo"], "sum(produtoItem)");
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(110, 3, 'Total Produto', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["produtoProcesso"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 3, '', 0, 0, 'L');
$pdf->Cell(10, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["produtoProcesso"], false), 0, 1, 'R');

$totalImpostosSaida["ipi"] = $importacoes->sumProcesso($processo["processo"], "sum(ipiSaida)");
$pdf->SetFont('Times', '', 8);
$pdf->Cell(110, 3, 'IPI', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["ipi"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 3, '', 0, 0, 'L');
$pdf->Cell(10, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["ipi"], false), 0, 1, 'R');

$totalImpostosSaida["nf"] = $totalImpostosSaida["ipi"] + $totalImpostosSaida["produtoProcesso"];
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(110, 3, 'Total da NF', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["nf"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(10, 3, '', 0, 0, 'L');
$pdf->Cell(10, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["nf"], false), 0, 1, 'R');
$pdf->Ln(4);

//=================== Custo para o Cliente =======
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(0, 5, 'Custo Efetivo para o Cliente', 0, 1, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0, 0, '', 1, 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Times', '', 8);

$pdf->Cell(55, 3, 'Valor da Nota Fiscal', 0, 0, 'L');
$pdf->Cell(55, 3, '', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["nf"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["nf"], false), 0, 1, 'R');

$totalIcmsESt = $totalImpostosSaida["icms"] + $totalImpostosSaida["icmsSt"];
$pdf->Cell(110, 3, 'ICMS - Total ICMS + ICMS ST -  Crédito Fiscal', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalIcmsESt / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalIcmsESt, false), 0, 1, 'R');


$pdf->Cell(55, 3, 'I.P.I - Crédito Fiscal', 0, 0, 'L');

if ($processo["industrial"] == 0) {
    $totalImpostosSaida["ipi"] = 0;
}

$pdf->Cell(15, 3, 'Industrial:', 0, 0, 'L');
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(40, 3, $bool[$processo["industrial"]], 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["ipi"] / $processo["txCambio"], false), 0, 0, 'R');

$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["ipi"], false), 0, 1, 'R');

$pdf->Cell(55, 3, 'PIS/COFINS - Crédito Fiscal', 0, 0, 'L');

if ($processo["lucroReal"] == 1) {
    $totalImpostosSaida["pis"] = $totalImpostosEntrada["pis"];
    $totalImpostosSaida["cofins"] = $totalImpostosEntrada["cofins"];
}

$pdf->Cell(15, 3, 'Lucro Real: ', 0, 0, 'L');
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(40, 3, $bool[$processo["lucroReal"]], 0, 0, 'L');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda(($totalImpostosSaida["pis"] + $totalImpostosSaida["cofins"]) / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda(($totalImpostosSaida["pis"] + $totalImpostosSaida["cofins"]), false), 0, 1, 'R');


$pdf->Cell(90, 3, 'Desconto Comercial', 0, 0, 'L');
$totalImpostosSaida["desconto"] = ($totalImpostosSaida["baseIcms"] * ($processo["desconto"] / 100));
$pdf->Cell(20, 3, "", 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["desconto"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["desconto"], false), 0, 1, 'R');

$pdf->SetFont('Times', 'B', 8);
$totalImpostosSaida["custoEfetivo"] = ($totalImpostosSaida["nf"] - $totalImpostosSaida["icms"] - $totalImpostosSaida["ipi"] - $totalImpostosSaida["pis"] - $totalImpostosSaida["cofins"] - $totalImpostosSaida["desconto"]);

$pdf->Cell(55, 3, '', 0, 0, 'L');
$pdf->Cell(55, 3, '', 0, 0, 'L');
$pdf->Cell(20, 3, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["custoEfetivo"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 3, 'R$', 0, 0, 'R');
$pdf->Cell(20, 3, $importacoes->formatMoeda($totalImpostosSaida["custoEfetivo"], false), 0, 1, 'R');
$pdf->Ln(3);

//=================== Desenbolso do Cliente =======
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(0, 5, 'Total a ser desembolsado pelo Cliente', 0, 1, 'L');
$pdf->Cell(0, 0, '', 1, 1, 'L');
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(70, 5, '', 0, 0, 'L');
$pdf->Cell(40, 5, 'Vencimento', 0, 1, 'L');
$pdf->SetFont('Times', '', 8);

$desembolso["mercadoria"] = $cifProcesso;
$pdf->Cell(70, 4, 'Mercadoria', 0, 0, 'L');
$pdf->Cell(40, 4, 'Acordo com Fornecedor', 0, 0, 'L');
$pdf->Cell(20, 4, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["mercadoria"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 4, 'R$', 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["mercadoria"], false), 0, 1, 'R');

$desembolso["impostos"] = ($totalImpostosEntrada["ii"] + $totalImpostosEntrada["pis"] + $totalImpostosEntrada["cofins"] + $totalImpostosSaida["ipi"] + $totalImpostosSaida["icms"]);
$pdf->Cell(70, 4, 'Impostos Alfandegários', 0, 0, 'L');
$pdf->Cell(40, 4, 'Na Chegada da Mercadoria', 0, 0, 'L');
$pdf->Cell(20, 4, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["impostos"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 4, 'R$', 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["impostos"], false), 0, 1, 'R');

$desembolso["desconto"] = $totalImpostosSaida["desconto"];
$pdf->Cell(70, 4, 'Desconto Comercial', 0, 0, 'L');
$pdf->Cell(40, 4, 'Na Chegada da Mercadoria', 0, 0, 'L');
$pdf->Cell(20, 4, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["desconto"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 4, 'R$', 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["desconto"], false), 0, 1, 'R');

$desembolso["custosAduaneiros"] = $totalDespesas;
$pdf->Cell(70, 4, 'Custos Aduaneiros', 0, 0, 'L');
$pdf->Cell(40, 4, 'Na Chegada da Mercadoria', 0, 0, 'L');
$pdf->Cell(20, 4, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($totalDespesas / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 4, 'R$', 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($totalDespesas, false), 0, 1, 'R');

$pdf->SetFont('Times', 'B', 8);

$desembolso["total"] = ($desembolso["mercadoria"] + $desembolso["impostos"] + $desembolso["custosAduaneiros"]) - $desembolso["desconto"];
$pdf->Cell(70, 4, '', 0, 0, 'L');
$pdf->Cell(40, 6, 'TOTAL', 0, 0, 'L');
$pdf->Cell(20, 4, $processo["moeda"]["simbolo"], 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["total"] / $processo["txCambio"], false), 0, 0, 'R');
$pdf->Cell(20, 4, 'R$', 0, 0, 'R');
$pdf->Cell(20, 4, $importacoes->formatMoeda($desembolso["total"], false), 0, 1, 'R');
$pdf->SetFont('Times', '', 8);
$pdf->Ln(3);


//Segunda Página
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 10, 'Memorial de Cálculo', 0, 1, 'C');

$pdf->SetFont('Times', '', 8);


foreach ($adicoes as $key => $adicao) {
    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(0, 5, 'Adição ' . ($key + 1) . ' - NCM: ' . $adicao["ncm"], 0, 1, 'L');
    $pdf->Cell(0, 0, '', 1, 1, 'L');
    $pdf->Ln(3);

    $pdf->Cell(18, 4, 'II: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(ii)"), "R$"), 0, 0, 'L');


    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(25, 4, 'CIF: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->fob($processo["processo"], $adicao["ncm"], null, "adicao", false, true) + $importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(frete+thc+seguro)"), "R$"), 0, 0, 'L');

    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(25, 4, 'Desp. Aduaneiras: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(despesasAduaneiras+taxaSiscomex)"), "R$"), 0, 1, 'L');

    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(18, 4, 'IPI: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(ipiSaida)"), "R$"), 0, 0, 'L');


    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(25, 4, 'ICMS: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(icmsSaida)"), "R$"), 0, 0, 'L');

    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(25, 4, 'Total do Produto: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(produtoItem)"), "R$"), 0, 1, 'L');

    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(18, 4, 'Pis/Cofins: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(pis+cofins)"), "R$"), 0, 0, 'L');

    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(25, 4, 'ICMS ST: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(icmsSt)"), "R$"), 0, 0, 'L');

    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(25, 4, 'Anti-Dumping: ', 0, 0, 'L');
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 4, $importacoes->formatMoeda($importacoes->sumAdicao($processo["processo"], $adicao["ncm"], "sum(antiDumping)"), "R$"), 0, 1, 'L');


    $tabela = <<<MYTABLE
<table width="100%" border="1">
  <tr>
    <td rowspan="2" width="40px" valign="middle" align="center">Descrição</td>
    <td rowspan="2" width="15px" valign="middle" align="center">Qtde</td>
    <td rowspan="2" width="28px" valign="middle" align="center">Custo Unit. s/ IPI</td>
    <td rowspan="2" width="26px" valign="middle" align="center">Total Produto</td>
    <td rowspan="2" width="24px" valign="middle" align="center">Valor IPI</td>
    <td colspan="2" width="50px" valign="middle" align="center">Custo</td>
  </tr>
  <tr>
    <td width="25px" align="center">Ex-Impostos</td>
    <td width="25px" align="center">Desembolso</td>
  </tr>
MYTABLE;

    foreach ($importacoes->getItensAdicao($processo["processo"], $adicao["ncm"]) as $item) {
        if ($processo["lucroReal"] == 0) {
            $item["exImpostos"] = $item["produtoItem"] - ($item["pis"] + $item["cofins"] + $item["icmsSaida"] + ($item["baseIcmsSaida"] * ($processo["desconto"]/100)));
        } else {
            $item["exImpostos"] = $item["produtoItem"] - ($item["icmsSaida"] + ($item["baseIcmsSaida"] * ($processo["desconto"]/100)));
        }

        $item["desembolso"] = $item["produtoItem"] + $item["ipiSaida"] + $item["icmsSt"] - ($item["baseIcmsSaida"] * ($processo["desconto"]/100));
        $tabela .=<<<MYTABLE
	<tr>
		<td>{$html->slice(40, "...", $item["estoque_produtos"]["pNumber"] . " - " . $item["estoque_produtos"]["descricao"])}</td>
		<td>{$item["qtd"]}</td>
		<td>{$importacoes->formatMoeda($item["produtoItem"] / $item["qtd"])}</td>
		<td>{$importacoes->formatMoeda($item["produtoItem"])}</td>
		<td>{$importacoes->formatMoeda($item["ipiSaida"])}</td>
		<td>{$importacoes->formatMoeda($item["exImpostos"] / $item["qtd"])}</td>
		<td>{$importacoes->formatMoeda($item["desembolso"] / $item["qtd"])}</td>
	  </tr>
MYTABLE;
    }
    $tabela .= <<<MYTABLE
</table>
MYTABLE;
    $pdf->Ln(4);
    $pdf->htmltable($tabela);
    $pdf->Ln(8);
}

//Terceira Página
//$pdf->Open();
$pdf->AddPage();

$data = array('Mercadoria' => ($fobProcessoME * $processo["txCambio"]), 'Frete Internacional' => ($desembolso["mercadoria"] - ($fobProcessoME * $processo["txCambio"])), 'Impostos' => $desembolso["impostos"], 'Custos Aduaneiros' => $totalDespesas);

//Pie chart
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, 'Estatística Importação', 0, 1);
$pdf->Ln(16);

$pdf->SetFont('Arial', 'B', 10);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
$pdf->Cell(45, 5, 'Mercadoria:');
$pdf->Cell(10, 5, $importacoes->formatMoeda($data['Mercadoria']), 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(45, 5, 'Frete Internacional:');
$pdf->Cell(10, 5, $importacoes->formatMoeda($data['Frete Internacional']), 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(45, 5, 'Impostos Alfandegários:');
$pdf->Cell(10, 5, $importacoes->formatMoeda($data['Impostos']), 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(45, 5, 'Custos Aduaneiros:');
$pdf->Cell(10, 5, $importacoes->formatMoeda($data['Custos Aduaneiros']), 0, 0, 'L');
$pdf->Ln();
$pdf->Ln(8);

$pdf->SetXY(80, $valY);
$col1 = array(100, 100, 255);
$col2 = array(255, 100, 100);
$col3 = array(255, 255, 100);
$col4 = array(255, 255, 0);
$pdf->PieChart(120, 50, $data, '%l (%p)', array($col1, $col2, $col3, $col4));
$pdf->Ln(22);

unset($data);

$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, 'Estatística Custo Local', 0, 1);
$pdf->Ln(16);
$pdf->SetFont('Arial', 'B', 7);
$col1 = array(100, 100, 255);
$col2 = array(255, 100, 100);
$col3 = array(255, 255, 100);
$col4 = array(200, 255, 0);
$col5 = array(189, 100, 255);
$col6 = array(102, 102, 100);
$col7 = array(255, 20, 100);
$col8 = array(255, 150, 0);
$col9 = array(100, 100, 255);
$col10 = array(152, 100, 100);
$col11 = array(125, 79, 200);
$col12 = array(123, 196, 255);
$col13 = array(100, 100, 200);
$col14 = array(255, 90, 15);
$col15 = array(230, 195, 100);
$col16 = array(255, 90, 90);
$col17 = array(90, 90, 255);
$col18 = array(90, 255, 90);
$col19 = array(123, 255, 123);
$col20 = array(123, 123, 255);
$col21 = array(255, 123, 123);


foreach ($despesasNacionalizacao as $despesa) {
    $data[$despesa["custo"]["nome"]] = $data[$despesa["custo"]["nome"]]+$despesa["valorTotal"];
    $pdf->Cell(35, 5, (!empty($despesa["custo"]["nome"])) ? $despesa["custo"]["nome"] : "Despesas Diversas");
    $pdf->Cell(10, 5, $importacoes->formatMoeda($despesa["valorTotal"]), 0, 1, 'L');
}
$pdf->Cell(35, 5, "Tx. Siscomex");
$pdf->Cell(10, 5, $importacoes->formatMoeda($processo["taxaSiscomex"]), 0, 1, 'L');

$pdf->SetXY(70, $valY + 75);
$pdf->PieChart(140, 60, $data, '%l (%p)', array($col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12, $col13, $col14, $col15, $col16, $col17, $col18, $col19, $col20, $col21));


//Imprime a Saida do Arquivo
$pdf->Output($processo["processo"] . " - Planilha.pdf", "I");
?>
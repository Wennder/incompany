<?php

//ini_set("display_errors",1);
//pr($exportadores);
$pdf->SetMargins(10, 10);

//define a fonte a ser usada
$pdf->SetFont('Times', '', 10);

//define o titulo
$pdf->SetTitle("Fechamento do Processo " . $processo["processo"]);
$pdf->HeaderPage();
//assunto
$pdf->SetSubject("Documento gerado com finalidade de fechamento do processo");
// posicao vertical  caso -1.. e o limite da margem
$pdf->SetY("-1");
    
$cont =1;
foreach ($exportadores as $exportador) {
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(45, 4, 'Exportador #'.$cont, 0, 1);
    $pdf->Cell(0, 0, '', 1, 1);
    $pdf->SetFont('Times', '', 8);
    $pdf->Ln();
    $pdf->Cell(45, 4, $exportador["fabricante"]["razaoSocial"], 0, 1);
    $pdf->Cell(45, 4, $exportador["fabricante"]["endereco"], 0, 1);
    $pdf->Cell(45, 4, $exportador["fabricante"]["cidade"] . ", " . $exportador["fabricante"]["pais"], 0, 1);
    //$pdf->Cell(45, 4, "Tel.:" . $exportador["fabricante"]["fone"] . "     FAX: " . $exportador["fabricante"]["fax"], 0, 1);

    $pdf->Ln(2);
    $cont++;
}

$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(45, 4, 'Adquirente', 0, 1);
$pdf->Cell(0, 0, '', 1, 1);
$pdf->SetFont('Times', '', 8);
$pdf->Ln();
$pdf->Cell(45, 4, $processo["cliente"]["razaoSocial"], 0, 1);
$pdf->Cell(45, 4, "CNPJ:" . $processo["cliente"]["cnpj"], 0, 1);
$pdf->Cell(45, 4, $processo["cliente"]["endereco"], 0, 1);
$pdf->Cell(45, 4, $processo["cliente"]["cidade"] . ", " . $optionsEstados[$processo["cliente"]["estado"]], 0, 1);
$pdf->Cell(45, 4, "Tel.:" . $processo["cliente"]["fone"] . "     FAX: " . $processo["cliente"]["fax"], 0, 1);

$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(45, 4, 'Mercadoria', 0, 1);
$pdf->Cell(0, 0, '', 1, 1);
$pdf->SetFont('Times', '', 8);
$pdf->Ln();
$pdf->Cell(45, 4, "Descrição: " . $processo["descricaoProdutos"], 0, 1);
$pdf->Cell(45, 4, "Navio: " . $navio["navio"], 0, 1);
$pdf->Cell(45, 4, "D.I: " . $processo["nDi"] . " de " . $date->format("d/m/Y", $processo["dtDi"]), 0, 1);
$pdf->Cell(45, 4, "Fatura Comercial: " . $processo["nInvoice"] . " de " . $date->format("d/m/Y", $processo["dtDi"]), 0, 1);
$pdf->Cell(45, 4, "BL: " . $processo["houseMaster"], 0, 1);
$pdf->Cell(45, 4, "Tx. Dolar: " . $processo["txCambio"], 0, 1);
$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(45, 4, 'Fechamento', 0, 1);
$pdf->Cell(0, 0, '', 1, 1);
$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(100, 4, "Descrição", 1, 0);
$pdf->Cell(30, 4, "Data", 1, 0);
$pdf->Cell(30, 4, "Valor", 1, 0);
$pdf->Cell(30, 4, "Tipo", 1, 1);

$pdf->SetFont('Times', '', 8);
$totais = array();
$tipos = array(
    "Débito",
    "Crédito"
);
foreach ($custos as $tCustos) {

    if (isset($tipoAnt) && ($tCustos["credito"] != $tipoAnt)) {
        $pdf->SetFont("Times", "B", 9);
        $pdf->Cell(130, 4, "Total " . $tipos[$tipoAnt] . "s", 1, 0);
        $pdf->Cell(60, 4, "R$ " . $financeiro->formatMoeda($totais[$tipoAnt]), 1, 1);
        $pdf->Ln();
        $pdf->SetFont("Times", "", 8);
    }

    if (empty($tipoAnt)) {
        $pdf->Cell(100, 4, $tCustos["descricao"], 1, 0);
        $pdf->Cell(30, 4, $date->format("d/m/Y", $tCustos["data"]), 1, 0);
        $pdf->Cell(30, 4, "R$ " . $tCustos["valor"], 1, 0);
        $pdf->Cell(30, 4, $tipos[$tCustos["credito"]], 1, 1);
    } elseif ($tCustos["credito"] == $tipoAnt) {
        $pdf->Cell(100, 4, $tCustos["descricao"], 1, 0);
        $pdf->Cell(30, 4, $date->format("d/m/Y", $tCustos["data"]), 1, 0);
        $pdf->Cell(30, 4, "R$ " . $financeiro->formatMoeda($tCustos["valor"]), 1, 0);
        $pdf->Cell(30, 4, $tipos[$tCustos["credito"]], 1, 1);
    }

    $tipoAnt = $tCustos["credito"];
    $totais[$tCustos["credito"]] = $totais[$tCustos["credito"]] + $tCustos["valor"];
}
$pdf->SetFont("Times", "B", 9);
$pdf->Cell(130, 4, "Total " . $tipos[$tipoAnt] . "s", 1, 0);

$pdf->Cell(60, 4, "R$ " . $financeiro->formatMoeda($totais[$tipoAnt]), 1, 0);
$pdf->Ln();
$pdf->SetFont("Times", "", 8);

$pdf->Cell(190, 4, "Total a Devolver: R$ " . $financeiro->formatMoeda($totais[1] + $totais[0]), 1, 1);

$pdf->Ln();

$pdf->Cell(190, 4, "Dados Bancários", 0, 1);
$pdf->Cell(190, 4, "Banco Bradesco Ag.: 0518-5        C/C : 66440-5", 0, 1);
$pdf->Cell(190, 4, "Favorecido: Syntex Assessoria e Consultoria em Negócios Ltda", 0, 1);
$pdf->Cell(190, 4, "CNPJ: 08.172.904/0002-97", 0, 1);

$pdf->Output("Fechamento - " . $dados["processo"] . ".pdf", "I");
?>

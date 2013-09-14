<?php
$optRating = array("-1"=>"Any","0"=>"C","1"=>"B","2"=>"A");
switch ($op) {
    case "filtro":
        echo $html->tag("script", "$(function(){ $('button,.botao, input:submit, input:button, button', 'html').button(); $('input:text').setMask();});");
        echo $form->create("/relatorios/comercial_mercado/imprimir", array("target" => "_blank", "id" => "filtroRelatorio", "class" => "formee"));
        echo $form->input("estado", array("type" => "select", "options" => $optionsEstados, "div" => "grid-12-12", "label" => "Região"));
        echo $form->input("categoria1", array("type" => "select", "label" => "Grupo", "div" => "grid-6-12", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria2', 'options');", "options" => $dadosCat1));
        echo $form->input("categoria2", array("type" => "select", "div" => "grid-6-12", "label" => "Tipo", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria3', 'options');"));
        echo $form->input("categoria3", array("type" => "select", "div" => "grid-6-12", "label" => "Aplicação", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria4', 'options');"));
        echo $form->input("categoria4", array("type" => "select", "label" => "Produto Final", "div" => "grid-6-12"));
        echo $form->input("classificacao", array("type" => "select","options"=>  $optRating, "label" => "Rating", "div" => "grid-4-12"));
        echo $form->input("cotacao", array("label" => "Cotação", "alt" => "moedaProduto", "div" => "grid-4-12"));
        echo $form->input("fatorImportacao", array("label" => "Fator", "alt" => "moedaProduto", "div" => "grid-4-12"));
        echo $form->close("Gerar", array("class" => "botao grid-6-12"));
        break;
    case "imprimir":
        $pdf->SetMargins(10, 10);
        $pdf->SetFont('Times', '', 10);
        $pdf->SetTitle("Market Report");
        $pdf->HeaderPage();
        $pdf->SetSubject("Dados para Análise de Consumo dos Clientes");
        $pdf->SetY("-1");
        $pdf->setFillColor(240, 240, 240);
        $estoqueCategorias[-1] = "Any";
        //Monta o Cabeçalho de Filtragem
        $pdf->Cell(190, 6, "Filter Selection", 0, 1);
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Cell(47.5, 6, ($filtro["estado"] > 0) ? "State: {$optionsEstados[$filtro["estado"]]}" : "Estado: Any", 1, 0);
        $pdf->Cell(47.5, 6, "Cambio / Exchance: {$filtro["cotacao"]}", 1, 0);
        $pdf->Cell(47.5, 6, "Fator / Import Cost: {$filtro["fatorImportacao"]}", 1, 0);
        $pdf->Cell(47.5, 6, "Rating:{$optRating[$filtro["classificacao"]]}", 1, 1);

        $pdf->Cell(47.5, 6, ($filtro["categoria1"] > 0) ? "Product Group: {$estoqueCategorias[$filtro["categoria1"]]}" : "Product Group: Any", 1, 0);
        $pdf->Cell(47.5, 6, ($filtro["categoria2"] > 0) ? "Type: {$estoqueCategorias[$filtro["categoria2"]]}" : "Type: Any", 1, 0);
        $pdf->Cell(47.5, 6, ($filtro["categoria3"] > 0) ? "Application: {$estoqueCategorias[$filtro["categoria3"]]}" : "Application: Any", 1, 0);
        $pdf->Cell(47.5, 6, ($filtro["categoria4"] > 0) ? "Final Product: {$estoqueCategorias[$filtro["categoria4"]]}" : "Final: Any", 1, 1);

        $pdf->Ln(3);
        //Escreve os Dados dos Clientes

        foreach ($dadosRelatorio as $cliente) {
            if ($categoriaAtual == $cliente["estoqueCategoria2"]) {
                $nItem = $nItem + 1;
            } else {
                if ($nItem >= 1 || $totalConsumo > 0) {
                    $pdf->Cell(15, 5, "", 1, 0, "L",1);
                    $pdf->Cell(40, 5, "", 1, 0, "L",1);
                    $pdf->Cell(20, 5, "", 1, 0, "L",1);
                    $pdf->Cell(30, 5, "{$totalConsumo}", 1, 0, "C",1);
                    $pdf->Cell(25, 5, "", 1, 0, "C",1);
                    $pdf->Cell(20, 5, "", 1, 0, "L",1);
                    $pdf->Cell(20, 5, "", 1, 0, "C",1);
                    $pdf->Cell(20, 5, "", 1, 1, "C",1);
                }
                $totalConsumo = 0;
                $nItem = 1;
            }
            $categoriaAtual = $cliente["estoqueCategoria2"];

            if ($nItem == 1) {
                //Escreve o Cabeçalho
                $pdf->Ln(3);
                $pdf->SetFont('Times', 'B', 10);
                $pdf->Cell(190, 5, strtoupper($cliente["cat1Nome"] . " - " . $cliente["cat2Nome"]), 1, 1, "C", true);
                $pdf->SetFont('Times', '', 10);
                $pdf->cell(15,5,"Rating",1,0,"C",true);
                $pdf->Cell(40, 5, "Customer", 1, 0, "C", true);
                $pdf->Cell(20, 5, "Application", 1, 0, "C", true);
                $pdf->Cell(30, 5, "Consumption", 1, 0, "C", true);
                $pdf->Cell(25, 5, "Feature", 1, 0, "C", true);
                $pdf->Cell(20, 5, "Competitor", 1, 0, "C", true);
                $pdf->Cell(20, 5, "Local Price", 1, 0, "C", true);
                $pdf->Cell(20, 5, "Date", 1, 1, "C", true);
                //Escreve os dados do cliente
                $pdf->cell(15,5, $optRating[$cliente["classificacao"]],1,0,"C");
                $pdf->Cell(40, 5, $html->slice(30, "...", $cliente["nomeFantasia"]), 1, 0, "L");
                $pdf->Cell(20, 5, $estoqueCategorias[$cliente["estoqueCategoria3"]], 1, 0, "C");
                $pdf->Cell(30, 5, ($cliente["unConsumo"] > 0) ? "{$cliente["qtdConsumo"]} {$unidadesMedida[$cliente["unConsumo"]]}" : "{$cliente["qtdConsumo"]}", 1, 0, "C");
                $pdf->Cell(25, 5, $cliente["modeloLocal"], 1, 0, "C");
                $pdf->Cell(20, 5, $cliente["concorrente"], 1, 0, "L");
                $pdf->Cell(20, 5, "R$ " . $cliente["precoLocal"], 1, 0, "C");
                $pdf->Cell(20, 5, $date->format("m/Y", $cliente["modified"]), 1, 1, "C");
            } else {
                $pdf->cell(15,5, $optRating[$cliente["classificacao"]],1,0,"C");
                $pdf->Cell(40, 5, $html->slice(30, "...", $cliente["nomeFantasia"]), 1, 0, "L");
                $pdf->Cell(20, 5, $estoqueCategorias[$cliente["estoqueCategoria3"]], 1, 0, "C");
                $pdf->Cell(30, 5, ($cliente["unConsumo"] > 0) ? "{$cliente["qtdConsumo"]} {$unidadesMedida[$cliente["unConsumo"]]}" : "{$cliente["qtdConsumo"]}", 1, 0, "C");
                $pdf->Cell(25, 5, $cliente["modeloLocal"], 1, 0, "C");
                $pdf->Cell(20, 5, $cliente["concorrente"], 1, 0, "L");
                $pdf->Cell(20, 5, "R$ " . $cliente["precoLocal"], 1, 0, "C");
                $pdf->Cell(20, 5, $date->format("m/Y", $cliente["modified"]), 1, 1, "C");
            }
            $totalConsumo = $totalConsumo + $cliente["qtdConsumo"];
        }
        $pdf->Output("Analise de Mercado.pdf", "I");

        break;
}
?>
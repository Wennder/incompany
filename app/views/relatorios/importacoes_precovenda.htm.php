<?php
switch ($op) {
    default:
    case "filtro":
        echo "<script>$(function(){
                $(\"button,.botao, input:submit, input:button, button\", \"html\").button();
                $(\"input:text\").setMask();
        });
            </script>";
        echo $form->create("/relatorios/importacoes_precovenda/imprimir/$idProcesso/", array("target" => "_blank"));
        echo $form->input("despesasFixas", array("label"=>"Despesas Fixas","alt" => "porcentagem", "div" => "Form33por FormLeft"));
        echo $form->input("irCsll", array("label"=>"IR-CSLL","alt" => "porcentagem", "div" => "Form33por FormLeft"));
        echo $form->input("pisCofins", array("label"=>"PIS e COFINS","alt" => "porcentagem", "div" => "Form33por FormRight"));
        echo $form->input("margem", array("alt" => "porcentagem", "div" => "Form33por FormLeft"));
        echo $form->input("aliqIcms", array("label"=>"Aliquota de ICMS","alt" => "porcentagem", "div" => "Form33por FormRight"));
        echo "<br clear='all'/>";
        echo $form->close("Gerar Relatório", array("class" => "botao"));
        break;
    case "imprimir":
        $pdf->SetMargins(10, 10);

//define a fonte a ser usada
        $pdf->SetFont('Times', '', 10);

//define o titulo
        $pdf->SetTitle("Preço de Venda - {$processo["processo"]}");

//assunto
        $pdf->SetSubject("Planilha de Calculo do Preço de Venda");

// posicao vertical  caso -1.. e o limite da margem
        $pdf->SetY("-1");
//Imprime o Título na Folha
        $pdf->SetFont("Times", "B", "10");

        $pdf->Ln(6);

        $destinos = array("Não Definido", "Comercialização", "Industização", "Consumo");

        $pdf->Cell(0, 4, "Processo:" . $processo["processo"], 1, 1, "L");
        $pdf->SetFont("Times", null, "8");
        $pdf->Cell(32.142, 4, "Destino: " . $destinos[$processo["destinacao"]], 1, 0, "L");
        $pdf->Cell(22, 4, "Lucro Real: " . $bool[$processo["lucroReal"]], 1, 0, "L");
        $pdf->Cell(27.142, 4, "Desp. Fixas: " . $filtro["despesasFixas"] . "%", 1, 0, "L");
        $pdf->Cell(27.142, 4, "Margem: " . $filtro["margem"] . "%", 1, 0, "L");
        $pdf->Cell(27.142, 4, "IR/CSLL: " . $filtro["irCsll"] . "%", 1, 0, "L");
        $pdf->Cell(27.142, 4, "ICMS: " . $filtro["aliqIcms"] . "%", 1, 0, "L");
        $pdf->Cell(27.300, 4, "Pis Cofins: " . $filtro["pisCofins"] . "%", 1, 0, "L");

        $pdf->Ln(12);
//Listagem dos Ítens
        foreach ($itens as $item) {
            $pdf->SetFont("Times", "B", "10");
            $pdf->Ln(6);
            if ($processo["lucroReal"] == 1) {
                $piscofinsItem = $item["pis"]+$item["cofins"];
                
            } else {
                $piscofinsItem = 0;
                
            }
            $iiItem = $item["ii"];

            $cifItem = $importacoes->fob($idProcesso,$item["ncm"],$item["id"],"item",false,true) +$item["frete"]+$item["thc"]+$item["seguro"];
            
            //Calculo do custo da mercadoria "Preco de venda".
            $numerador = ($cifItem + $iiItem + $piscofinsItem + $item["despesasAduaneiras"]+$item["taxaSiscomex"]+$item["antiDumping"]);
            if ($processo["destinacao"] !=1) {
                $destinoIPI = (($item["aliqIpi"] / 100) / (1 + ($item["aliqIpi"] / 100)));
            } else {
                $destinoIPI = ($item["aliqIpi"] / 100);
            }
            $pisCofinsPV = ($filtro["pisCofins"] / 100) / (1 + ($item["aliqIpi"] / 100));
            $denominadorPV = 1 - ((($filtro["aliqIcms"] + $filtro["irCsll"] + $filtro["margem"] + $filtro["despesasFixas"]) / 100) + $destinoIPI + $pisCofinsPV);
            $precoVenda = $numerador / $denominadorPV;
            //$aliqs = 1-();

            $pdf->Cell(20, 5, "Produto: ", 0, 0, "L");
            $pdf->Cell(20, 5,$html->slice(40,"...",$item["estoque_produtos"]["pNumber"]." - ".$item["estoque_produtos"]["descricao"]), 0, 1, "L");

            $pdf->Cell(30, 5, "CIF:", 0, 0, "L");
            $pdf->Cell(20, 5, "R$ " . $financeiro->formatMoeda($cifItem), 0, 1, "L");

            $pdf->Cell(30, 5, "II:", 0, 0, "L");
            $pdf->Cell(20, 5, "R$ " . $financeiro->formatMoeda($iiItem), 0, 1, "L");

            $pdf->Cell(30, 5, "Pis/Cofins:", 0, 0, "L");
            $pdf->Cell(20, 5, "R$ " . $financeiro->formatMoeda($item["pis"]+$item["cofins"]), 0, 1, "L");

            $pdf->Cell(30, 5, "Desp. Ad.:", 0, 0, "L");
            $pdf->Cell(20, 5, "R$ " . $financeiro->formatMoeda($item["despesasAduaneiras"]+$item["taxaSiscomex"]+$item["antiDumping"]), 0, 1, "L");

            $pdf->Cell(30, 5, "P. Venda Total:", 0, 0, "L");
            $pdf->Cell(20, 5, "R$ " . $financeiro->formatMoeda($precoVenda), 0, 1, "L");
            
            $pdf->Cell(30, 5, "P. Venda Unit:", 0, 0, "L");
            $pdf->Cell(20, 5, "R$ " . $financeiro->formatMoeda($precoVenda/$item["qtd"]), 0, 1, "L");


            $valX = $pdf->GetX();
            $valY = $pdf->GetY();
            $pdf->SetXY(95, $valY - 40);
            $ImpostosVenda = ((($filtro["irCsll"] + $filtro["aliqIcms"]) / 100) + $pisCofinsPV + $destinoIPI) * 100;
            $custoEstoque = ($numerador / $precoVenda) * 100;

            $data = array('Custo Estoque' => $custoEstoque, 'Impostos - Venda' => $ImpostosVenda, 'Despesas Fixas' => $filtro["despesasFixas"], "Margem" => $filtro["margem"]);
            $col1 = array(100, 100, 255);
            $col2 = array(255, 100, 100);
            $col3 = array(255, 255, 100);
            $col4 = array(255, 255, 0);
            $pdf->PieChart(110, 50, $data, '%l (%p)', array($col1, $col2, $col3, $col4));
            $pdf->Ln(18);
            $pdf->Cell(0, 0, "", 1, 1, "L");
            $pdf->Ln(7);
        }

        $pdf->Output("PrecoVenda-" . date("dmy") . " - $idProcesso.pdf", "I");
        break;
}
?>
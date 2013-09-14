<?php
switch ($op) {
    case "filtro":
        echo $html->tag("script", "$(function(){ $('button,.botao, input:submit, input:button, button', 'html').button(); $('input:text').setMask();});");
        echo $form->create("/relatorios/comercial_fichaCliente/imprimir", array("target" => "_blank", "id" => "filtroRelatorio", "class" => "formee"));
        echo $form->input("estado", array("type" => "select", "options" => $optionsEstados, "div" => "grid-4-12", "label" => "Estado", "onChange" => "populaCombo('/integracao/options/sys_municipios/nome/-1/uf/'+this.value, '#FormCidade', 'options');"));
        echo $form->input("cidade", array("type" => "select", "options" => array("-1" => "Selecione o Estado"), "div" => "grid-8-12", "label" => "Cidade"));
        echo $form->input("categoria1", array("type" => "select", "label" => "Grupo", "div" => "grid-6-12", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria2', 'options');", "options" => $dadosCat1));
        echo $form->input("categoria2", array("type" => "select", "div" => "grid-6-12", "label" => "Tipo", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria3', 'options');"));
        echo $form->input("categoria3", array("type" => "select", "div" => "grid-6-12", "label" => "Aplicação", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria4', 'options');"));
        echo $form->input("categoria4", array("type" => "select", "label" => "Produto Final", "div" => "grid-6-12"));
        echo $form->input("destinacao", array("type" => "select", "label" => "Destinação", "div" => "grid-12-12", "options" => array("Ficha Sintética", "Ficha Analítica")));
        echo $form->close("Gerar", array("class" => "botao grid-6-12"));
        break;

    case "imprimir":
        $pdf->SetMargins(10, 10);
        $pdf->SetFont('Times', '', 10);
        $pdf->SetTitle("Ficha Comercial - Clientes");
        $pdf->HeaderPage();
        $pdf->SetSubject("Dados do Cliente");
        $pdf->SetY("-1");
        $pdf->setFillColor(240, 240, 240);

        $pdf->SetFont('Times', '', 10);

//Escreve os Dados dos Clientes
        foreach ($dadosRelatorio as $cliente) {
            
            if ($filtro["destinacao"] == 0) {
                $linhaConsumo = "Consumo: <br>";
                foreach($cliente["consumo"] as $consumo){
                    $linhaConsumo .= "{$consumo["qtdConsumo"]} {$estoqueCategorias[$consumo["estoqueCategoria1"]]} > {$estoqueCategorias[$consumo["estoqueCategoria2"]]} > {$estoqueCategorias[$consumo["estoqueCategoria3"]]} > {$estoqueCategorias[$consumo["estoqueCategoria4"]]} <br>";
                }
                
                $linhaContato = "Contatos<br>";
                foreach($cliente["contatos"] as $contato){
                    $linhaContato .= "{$contato["nome"]} - {$contato["email"]}<br>";
                    $linhaContato .= "{$contato["tel1"]} - {$contato["tel2"]}<br>";
                }
                $dadosCliente = <<<MYTABLE
                        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                       <tr>
                         <td colspan="2" bgcolor="#f0f0f0" align=center>{$cliente["razaoSocial"]}</td>
                       </tr>
                       <tr>
                         <td width="50%">Nome Fantasia: {$cliente["nomeFantasia"]}<br>
                             Localização: {$cliente["municipio"]["nome"]} - {$optionsEstados[$cliente["estado_id"]]}<br>
                             Tel: {$cliente["fone"]}<br>
                             {$linhaConsumo}</td>
                         <td width="50%">{$linhaContato}</td>
                       </tr>
                     </table>
MYTABLE;
                $pdf->htmlTable($dadosCliente);
                $pdf->Ln(6);
            } else {
                $pdf->Ln(4);
                $pdf->Cell(95, 4, "{$cliente["razaoSocial"]}\nLocalização: {$cliente["municipio"]["nome"]} - {$optionsEstados[$cliente["estado_id"]]}\nTelefone: {$cliente["fone"]}\nEmail: {$cliente["email"]}", 1, 1);
                $pdf->Ln();
                $pdf->Cell(190, 0, "", 1, 1);
            }
        }
        $pdf->Output("Ficha Analitica.pdf", "I");
        break;
}
?>

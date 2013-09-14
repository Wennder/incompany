<?php
if(in_array("1000",$pagesAvaible)||in_array("1040",$pagesAvaible)){
echo $html->openTag("h3");
echo "Status Financeiro";
echo $html->closeTag("h3");
echo $html->openTag("div");
$mesAn = mktime(0, 0, 0, date("m") - 1, 01, date("Y"));
$mesAn = date("Y-m-d", $mesAn);
$totalMes = $assistec->statusFinanceiroValor(array("conditions" => array("modified >=" => date("Y-m-01"), "status_id" => "3"), "fields" => "sum(valor)"));
$totalMesAnt = $assistec->statusFinanceiroValor(array("conditions" => array("modified BETWEEN" => array($mesAn, date("Y-m-01")), "status_id" => "3"), "fields" => "sum(valor)"));
?>
<div class="mostradorStatusLateral">
    <ul>
        <li>Qtd. de Solicitações: <div><?php echo $assistec->statusFinanceiro(); ?></div></li>
        <li>Pago Este Mês:<div><?php echo $html->moeda($totalMes["sum(valor)"]); ?></div></li>
        <li>Pago Mês Passado:<div><?php echo $html->moeda($totalMesAnt["sum(valor)"]); ?></div></li>
    </ul>
</div>
<?php
echo $html->closeTag("div");
}
?>
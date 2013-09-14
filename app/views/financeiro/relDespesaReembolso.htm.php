<div id="printable">
<div class="titulo">Solicitações Aguardando Pagamento</div>
<?php
foreach($aPagar as $pagar){
if ($usuario != $pagar["beneficiario"]){
if ($subTotal != 0){
    echo "<font size='+1'>Total desse Funcionário: R$".number_format($subTotal, 2,".",",")."</font>";
    echo "<br/><br/><br/>";
    $subTotal = 0;
}

?>
<div class="tituloRel">
    _____________________________________________________________<br/>
<?php echo $pagar["rh_funcionarios"]["nome"]; ?>
</div>


<?php
}

?>
<table border="0">
    <tr>
        <td width="300px" valign="top">
            <div class="borda">
                <strong>Solicitação de Reembolso </strong># <?php echo $pagar["id"]; ?><br/>
                <strong>Tipo de despesa: </strong><?php echo $pagar["tipodespesa"]["nome"] ?><br/>
                <strong>Motivo da despesa: </strong><?php echo $pagar["financeiro_motivodespesa"]["nome"] ?><br/>
                <strong>Gerente:</strong> <?php echo $pagar["rh_funcionarios"]["gerente_funcionario"]["nome"] ?><br/><br/>
                <strong>Valor: </strong><?php echo $pagar["valor"]?><br/><br/>
            </div>
        </td>
        <td width="300px" valign="top">
            <div class="borda">
                <strong>Observações do Técnico:</strong><br/>
                <?php
                echo $pagar["observacao"];
                ?>
                <br/>
                <strong>Observações do Gerente:</strong><br/>
                <?php
                echo $pagar["obsGerente"];
                ?>
            </div>
        </td>
    </tr>
</table>
<br/>
<?php
$subTotal = $subTotal+$pagar["valor"];
$total = $total+$pagar["valor"];
$usuario = $pagar["beneficiario"];
}
echo "<font size='+1'>Total desse Funcionário: R$".number_format($subTotal, 2,".",",")."</font><br/>";
echo "_____________________________________________________________<br/><br/><br/>";
echo "<font size='+1'>Total Geral: R$".number_format($total, 2,".",",")."</font>";
echo "<br/><br/><br/>";
?>
</div>
<script type="text/javascript">
    $(function(){

       $("#sidebar").html("<center><a class='botao' href='javascript:void(0);' onclick='javascript:window.print();'>Imprimir</a><center><br/>");
       $("button,.botao, input:submit, input:button, button", "html").button();
    });
</script>
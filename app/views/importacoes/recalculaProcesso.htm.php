<?php

ini_set("display_errors", 1);
$recalcula = $importacoes->calcAll($processo);
if ($recalcula["save"]) {
    echo $html->printWarning("Recalculado com Sucesso");
    if ($recalcula["tipoProcesso"] == 1) {
        echo $html->tag("script", "loadDiv('#contMemorialCalculo','/importacoes/memorialCalculo/$processo');");
    } else {
        echo $html->tag("script", "loadDiv('#main','/importacoes/orcamento/$processo');");
    }
} else {
    echo $html->printWarning("Erro durante o calculo, verifique com o Administrador do Sistema");
}
?>

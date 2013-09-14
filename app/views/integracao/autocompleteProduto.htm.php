<?php
foreach($return as $retorno){
    $lista[] = array(
        "id" => $retorno["id"],
        "label" => $retorno["descricao"],
        "value" => $retorno["descricao"],
        "ncm" => $retorno["ncm"],
        "peso" => $retorno["peso"],
        "preco" => $retorno["preco"],
        "precoExterior" => $retorno["precoExterior"],
        "cti" => $retorno["cti"],
        "cst" => $retorno["cst"],
        "tipoAntiDumping" => $retorno["tipoAntidumping"],
        "aliqAntiDumping" => $retorno["aliqAntidumping"],
        "aliqii" => $retorno["cod_ncm"]["aliqIi"],
        "aliqipi" => $retorno["cod_ncm"]["aliqIpi"],
        "aliqpis" => $retorno["cod_ncm"]["aliqPis"],
        "aliqcofins" => $retorno["cod_ncm"]["aliqCofins"],
        "aliqicmsst" => $retorno["cod_ncm"]["aliqIcmsSt"]
    );
}

echo json_encode($lista);

?>

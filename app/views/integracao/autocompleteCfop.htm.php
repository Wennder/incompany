<?php
//pr($return);
foreach($return as $retorno){
    $lista[] = array(
        "id" => $retorno["id"],
        "label" => $retorno["nome"],
        "value" => $retorno["nome"]
    );
}
echo json_encode($lista);
?>

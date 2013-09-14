<?php
echo "<option value=0>Selecione...</option>";
foreach($bancos  as $banco){
    echo "<option value='{$banco["id"]}'>{$banco["nome"]}</option>";
}
?>

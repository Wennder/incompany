<?php
//pr($options);

//echo $html->tag("option","Selecione...",array("value"=>"0"));

foreach($options as $id=>$name){
    if ($selecionado > 0 and $selecionado == $id) {
                $attr = array("selected"=>"1");
            }
            $attr["value"]=$id;
    echo $html->tag("option",$name,$attr);
    $attr = array();
}
echo $html->tag("option","Adicionar Novo",array("onFocus"=>"AbreJanela('/importacoes/agentesCarga/cadastrar', 500, 400, 'Cadastro de Agentes de Carga', null, true);"));
?>

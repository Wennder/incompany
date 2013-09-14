<?php

echo $html->openTag("div", array("id"=>"mensageiro"));

echo $xgrid->start($mensageiro->upDate($usuario,$empresa))
        ->caption(false)
        ->tableClass("tabelaMensageiro")
        ->noData("Nenhum Funcionário Online")
        ->alternate("grid_claro","grid_escuro")
        ->col("id")->cell("/online.png","javascript:AbreJanela('/mensageiro/criaConversa/{id_user}',500,455,'Janela de Conversa');",array("border"=>"0"))->title("")
        ->col("modified")->hidden()
        ->col("users")->hidden()
        ->col("local")->hidden()
        ->col("id_user")->hidden()
        ->col("sysEmpresas_id")->hidden()
        ->col("rh_funcionarios")->cellArray("nome")->title("");
echo $html->closeTag("div");
?>

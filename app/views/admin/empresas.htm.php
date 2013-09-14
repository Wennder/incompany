<?php
//pr($dadosGrid);
echo $xgrid->start($dadosGrid)
        ->caption("Empresas")
        ->col("sys_grupo_empresa")->hidden()
        ->col("created")->hidden()
        ->col("nomeFantasia")->title("Nome Fantasia")
        ->col("cnpj")->title("CNPJ")
        ->col("cidade")->title("Cidade")
        ->col("id")->title("Ver/Editar")->conditions("id",array(">=1"=>array("label"=>"editar.gif","href"=>"javascript:loadDiv('#contAdmin','/admin/novaEmpresa/{id}');","border"=>"0")))
        ->alternate("grid_claro","grid_escuro");
?>
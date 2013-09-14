<?php
echo $xgrid->start($solicitacoes)
        ->caption("Minhas Solicitações")
        ->col("created")->date("d/m/Y h:i")->title("Data")
        ->col("status_id")->title("Status")->conditions("status_id",$statusAtendimento)
        ->col("rh_setor_id")->title("Depto.")->conditions("rh_setor_id",$deptoAtendimento)
        ->col("id")->title("#")->conditions("id",array(">=1"=>array("href"=>"/home/verSolicitacao/{id}")));

?>

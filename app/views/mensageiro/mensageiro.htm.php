<?php

echo "<script>";

foreach ($mensageiro->verificaConversa($loggedUser["id"]) as $dados) {
    echo "if($('#conversa{$dados["sysmensageiro_id"]}').length){
//manda abrir Janela do Talk
}else{AbreJanela('/mensageiro/janelaConversa/" . $dados["sysmensageiro_id"] . "',500,455,'Janela de Conversa');}";
}
echo "</script>";
echo $this->element("/gadgets/mensageiro", array("usuario" => $loggedUser["id"], "funcionarios" => $funcionariosCad));
?>

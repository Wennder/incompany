<?php
class gadgetsHelper extends Helper{

    public function checkPermission($permissao){
        
    }

    //Dados para o grafico de Entrada e Saída de colaboradores dos ultimos
    //12 meses
    public function getEntradasSaidasRh(){
        $rh_funcionarios = ClassRegistry::load("rh_funcionarios", "Model");
        $conditions["entrada"] = array(
            "conditions"=>array(
                "dt_desligamento"=>"0000-00-00",
                "DATEDIFF(NOW(),dt_admissao) < 365"
            ),
            "fields"=>"count(*) as qtd,concat(month(dt_admissao),'-',year(dt_admissao)) as mes",
            "key"=>"mes",
            "displayField"=>"qtd",
            "groupBy"=>"month(dt_admissao)",
            "order"=>"year(dt_admissao) ASC,month(dt_admissao) ASC"
        );
        $conditions["saida"] = array(
            "conditions"=>array(
                "DATEDIFF(NOW(),dt_desligamento) < 365"
            ),
            "fields"=>"count(*) as qtd,concat(year(dt_desligamento),'-',month(dt_desligamento)) as mes",
            "key"=>"mes",
            "displayField"=>"qtd",
            "groupBy"=>"month(dt_desligamento)",
            "order"=>"year(dt_desligamento) ASC,month(dt_desligamento) ASC"
        );
        $retorno["entradas"] = $rh_funcionarios->toList($conditions["entrada"]);
        $retorno["saidas"] = $rh_funcionarios->toList($conditions["saida"]);
        return $retorno;
    }
}

?>

<?php

class importacoes_nacionalizacao extends AppModel {

    public $hasOne = array(
        "custo" => array(
            "className" => "importacoes_nomecustos",
            "primaryKey" => "id",
            "foreignKey" => "custo_id"
        )
    );
    
    public function allWithFormula($processo){
        $query = "select nacio.id, nacio.valorUnitario, nacio.valorTotal,nomeCustos.multiplicacao,(select terminalAtraque from importacoes_processos where processo='{$processo}') as terminal_id, (select formaCalculo from importacoes_configTerminais where terminais_id=terminal_id and custo_id=nacio.custo_id) as formula,(select valorUnitario from importacoes_configTerminais where terminais_id=terminal_id and custo_id=nacio.custo_id) as valorTerminal from importacoes_nacionalizacao nacio Right Join importacoes_nomeCustos nomeCustos on nacio.custo_id = nomeCustos.id where nacio.processo='{$processo}';";
        return $this->fetch($query);
    }

}

?>

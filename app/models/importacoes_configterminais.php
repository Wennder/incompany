<?php

class importacoes_configterminais extends AppModel {

    public $table = "importacoes_configTerminais";
    
    public $hasOne = array(
        "terminal" => array(
            "className" => "importacoes_terminais",
            "primaryKey" => "id",
            "foreignKey" => "terminais_id"
        ),"custo" => array(
            "className" => "importacoes_nomecustos",
            "primaryKey" => "id",
            "foreignKey" => "custo_id"
        )
    );

}

?>

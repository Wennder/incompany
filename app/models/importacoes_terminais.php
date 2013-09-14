<?php
class importacoes_terminais extends AppModel{
    public $hasMany = array(
        "confCustos"=>array(
            "className"=>"importacoes_configterminais",
            "primaryKey"=>"id",
            "foreignKey"=>"terminais_id"
        )
    );
}
?>

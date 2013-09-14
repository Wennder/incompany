<?php

class estoque_produtos extends AppModel {
    public $table = "estoque_produtos";

    public $hasOne = array(
        "moeda" => array(
            "className" => "sys_moedas",
            "primaryKey" => "id",
            "foreignKey" => "moedas_id"
        ),
        "cod_ncm" => array(
            "className" => "sys_ncm",
            "primaryKey" => "ncm",
            "foreignKey" => "ncm"
        ),
        "fornecedor"=>array(
            "className"=>"estoque_fornecedores",
            "primaryKey"=>"id",
            "foreignKey"=>"fabricantes_id"
        )
    );

}

?>

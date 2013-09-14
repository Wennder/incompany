<?php

class eticket_pedidos extends AppModel {

    public $hasOne = array(
        "eticket_status" => array("className" => "eticket_status", "primaryKey" => "id", "foreignKey" => "status_id"),
        "rh_setor" => array("className" => "rh_setor", "primaryKey" => "id", "foreignKey" => "rh_setor_id")
    );
    public $hasMany = array("eticket_respostas" => array("className" => "eticket_respostas", "primaryKey" => "id", "foreignKey" => "sys_solicitacoes_id"));

}
?>

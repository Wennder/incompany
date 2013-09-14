<?php

class eticket_respostas extends AppModel {

    public $hasMany = array(
        "eticket_status" => array("className" => "eticket_status", "primaryKey" => "id", "foreignKey" => "status_id"),
        "rh_setor" => array("className" => "rh_setor", "primaryKey" => "id", "foreignKey" => "rh_setor_id")
    );

}
?>
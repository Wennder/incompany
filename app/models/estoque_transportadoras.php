<?php
class estoque_transportadoras extends AppModel{
    public $hasOne = array(
        "municipio" => array("className" => "sys_municipios", "primaryKey" => "id", "foreignKey" => "cidade")
    );
}
?>

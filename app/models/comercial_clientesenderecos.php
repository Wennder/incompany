<?php
class comercial_clientesenderecos extends AppModel{
    public $table = "comercial_clientesEnderecos";
    
    public $hasOne = array(
        "municipio" => array("className" => "sys_municipios", "primaryKey" => "id", "foreignKey" => "cidade")
    );
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

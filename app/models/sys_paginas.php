<?php
class sys_paginas extends AppModel{
    public $hasOne = array(
      "modulo"=>array("className"=>"sys_modulos","primaryKey"=>"id_modulo","foreignKey"=>"id_modulo")
    );
}
?>

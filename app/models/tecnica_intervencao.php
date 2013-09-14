<?php

class tecnica_intervencao extends AppModel{
     public $table="tecnica_intervencaoFiscal";
     public $hasOne = array("rh_funcionarios"=>array("className"=>"rh_funcionarios","primaryKey"=>"id","foreignKey"=>"funcionario_id"),
     			    "comercial_clientes"=>array("className"=>"comercial_clientes","primaryKey"=>"id","foreignKey"=>"id_cliente"));
     			    }



?>
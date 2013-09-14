<?php
class sys_online extends AppModel{
   public $hasOne = array("rh_funcionarios"=>array("foreignKey"=>"id_user","primaryKey"=>"id"));
}
?>

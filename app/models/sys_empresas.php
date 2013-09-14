<?php
class sys_empresas extends AppModel{ 
   public $hasOne = array("SysGrupoEmpresa"=>array("className"=>"SysGrupoEmpresa","primaryKey"=>"id","foreignKey"=>"grupoEmpresa_id"));
}
?>

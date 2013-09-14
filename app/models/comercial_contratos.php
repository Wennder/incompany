<?php
class comercial_contratos extends AppModel{
    public $table = "comercial_contratos";
    public $hasOne = array(
        "tipoContrato"=>array("primaryKey"=>"id","foreignKey"=>"id_tipo","className"=>"comercial_tipo_contrato"),
        "cliente"=>array("primaryKey"=>"id","foreignKey"=>"id_cliente","className"=>"comercial_clientes"),
        "gerente"=>array("primaryKey"=>"id","foreignKey"=>"id_gerente","className"=>"rh_funcionarios"),
        "empresa"=>array("primaryKey"=>"id","foreignKey"=>"prestadora","className"=>"sys_empresas")
    );
    public $hasMany = array(
      "aditamento"=>array("className"=>"comercial_aditamento","primaryKey"=>"id","foreignKey"=>"contrato_id")
    );
}
?>

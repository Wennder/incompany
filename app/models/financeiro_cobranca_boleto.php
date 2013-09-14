<?php
class financeiro_cobranca_boleto extends AppModel{
    public $table = "financeiro_cobrancaBoleto";
    public $hasOne = array(
        "banco"=>array("className"=>"financeiro_conf_boleto","primaryKey"=>"id","foreignKey"=>"financeiroBancos_id"),
        "cliente"=>array("className"=>"comercial_clientes","primaryKey"=>"id","foreignKey"=>"comercialCliente_id"),
        "empresa"=>array("className"=>"sys_empresas","primaryKey"=>"id","foreignKey"=>"sysEmpresas_id")
        );
}

?>

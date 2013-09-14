<?php
class financeiro_conf_boleto extends AppModel{

    public $table = "financeiro_confBoleto";

    public $hasOne = array(
        "empresa"=>array("className"=>"sys_empresas","primaryKey"=>"id","foreignKey"=>"id_empresa"),
        "banco"=>array("className"=>"financeiro_bancos","primaryKey"=>"id","foreignKey"=>"cod_banco")
    );
}
?>

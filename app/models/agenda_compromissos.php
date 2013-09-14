<?php
class agenda_compromissos extends AppModel{
    public $hasOne = array("rh_funcionarios"=>array("primaryKey"=>"id","foreignKey"=>"funcionario_id"));
}
?>
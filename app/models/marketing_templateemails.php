<?php

class marketing_templateemails extends AppModel {

    public $table = "marketing_templateEmails";
    
    public $hasOne = array(
      "modulo"=>array("className"=>"sys_modulos","primaryKey"=>"id_modulo","foreignKey"=>"id_modulo")
    );
    
    public function listaModulo($modulo){
        $condicao = array(
            "conditions"=>array(
                "editavel"=>0,
                "id_modulo"=>$modulo
            ),
            "displayField"=>"titulo",
            "order"=>"titulo"
        );
        return $this->toList($condicao);
    }

}

?>

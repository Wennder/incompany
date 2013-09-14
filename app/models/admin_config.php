<?php
class admin_config extends AppModel{
    
    
    public function getId($modulo, $configuracao){
        $condicao = array(
            "conditions"=>array(
                "modulo"=>$modulo,
                "config"=>$configuracao
            )
        );
        $retorno = $this->first($condicao);
        
        return $retorno["id"];
    }
    
    public function getConfig($modulo, $configuracao){
        $condicao = array(
            "conditions"=>array(
                "modulo"=>$modulo,
                "config"=>$configuracao
            )
        ); 
        
        return $this->first($condicao);
    }
    
    public function beforeSave($data) {
        $data["id"] = $this->getId($data["modulo"], $data["config"]);
        return $data;
    }
}
?>
<?php

class comercial_contatos extends AppModel{
    
    
    public function toGrid($modulo,$pagina,$ref){
        $condicao = array(
            "conditions"=>array(
                "id_modulo"=>$modulo,
                "referencia"=>$ref,
            ),
            "fields"=>array(
                "id",
                "email",
                "tel1",
                "tel2",
                "txt",
                "blb"
            )
        );
        
        return $this->all($condicao);
    }
}
?>

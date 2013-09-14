<?php

class admsiteController extends AppController {
    
    public $uses = array(
        "site_paginas"
    );

    function index() {
        
    }

    function Pages($op,$id) {

        $this->set("op", $op);
        switch ($op) {

            default:
            case "grid":
                $this->set("dadosGrid", $this->site_paginas->all());
                break;

            case "add":
                if (!empty($this->data)) {
                    $this->data["titulo_id"] = ereg_replace("[^a-zA-Z0-9_]", "", strtr($this->data["titulo"], "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC-"));
                    $this->data["id"] = $id;
                    if($this->site_paginas->save($this->data)){
                       $this->redirect("/admsite/"); 
                    }
                }
                $this->set("dadosForm",$this->site_paginas->firstById($id));
                break;

            case "delete":
                $this->site_paginas->delete($id);
                $this->redirect("/admsite/");
                break;
        }
    }

    public function categories($op) {

        $this->set("op", $op);

        switch ($op) {
            default:
            case "add":
                $this->data["tituloID"] = ereg_replace("[^a-zA-Z0-9_]", "", strtr($this->data["titulo"], "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC-"));
                break;

            case "grid":

                break;

            case "delete":

                break;
        }
    }

}

?>
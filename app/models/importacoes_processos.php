<?php

class importacoes_processos extends AppModel {

    public $hasOne = array(
        "cliente" => array(
            "className" => "comercial_clientes",
            "primaryKey" => "id",
            "foreignKey" => "cliente_id"
        ),
        "fornecedores" => array(
            "className" => "importacoes_fabricantesprocesso",
            "primaryKey" => "processo",
            "foreignKey" => "processo"
        ),
        "terminal" => array(
            "className" => "importacoes_terminais",
            "primaryKey" => "id",
            "foreignKey" => "terminalAtraque"
        ),
        "operacao" =>array(
            "className"=>"importacoes_operacoes",
            "primaryKey"=>"id",
            "foreignKey"=>"operacao"
        ),
        "contato"=>array(
            "className"=>"comercial_contatos",
            "primaryKey"=>"id",
            "foreignKey"=>"contato_id"
        ),
        "moeda"=>array(
            "className"=>"sys_moedas",
            "primaryKey"=>"id",
            "foreignKey"=>"moeda"
        )
    );
    
    public function dashBoard(){
        return array(
            "orcamentos"=>$this->orcamentos(),
            "emProcessamento"=>$this->emProcessamento(),
            "agAtracacao"=>$this->agAtracacao(),
            "agDesembaraco"=>$this->agDesembaraco()
        );
    }
    
    public function orcamentos(){
        $condicaoProcesso = array(
            "conditions"=>array(
                "tipoProcesso"=>"0"
            ),
            "order"=>"created DESC",
            "limit"=>"16"
        );
        return $this->all($condicaoProcesso);
    }
    
    public function emProcessamento(){
        $condicaoProcesso = array(
            "conditions"=>array(
                "tipoProcesso"=>"1",
                "embarcado"=>"0"
            ),
            "order"=>"created DESC",
            "limit"=>"8"
        );
        return $this->all($condicaoProcesso);
    }
    
    public function agAtracacao(){
        $condicaoProcesso = array(
            "conditions"=>array(
                "tipoProcesso"=>"1",
                "embarcado"=>"1",   
            ),
            "or"=>array(
                    "eta <"=>date("Y-m-d"),
                    "eta"=>"0000-00-00"
                ),
            "order"=>"created DESC",
            "limit"=>"8"
        );
        return $this->all($condicaoProcesso);
    }
    
    public function agDesembaraco(){
        $authComponent = ClassRegistry::load("AuthComponent","Component");
        $by = $authComponent->user();
        
        $queryDesembaraco = "select *, cliente.* from importacoes_processos as processos inner join comercial_clientes as cliente on processos.cliente_id = cliente.id where processos.eta <= CURDATE() and processos.eta!= null and (select count(*) from importacoes_anexos where processo=processos.processo and doc =5) = 0 and processos.tipoProcesso = 1 and processos.owner={$by["empresa_id"]}";
        
        return $this->fetch($queryDesembaraco);
    }
    
    public function mercadoriaLiberada(){
        $authComponent = ClassRegistry::load("AuthComponent","Component");
        $by = $authComponent->user();
        
        $queryDesembaraco = "select *, cliente.* from importacoes_processos as processos inner join comercial_clientes as cliente on processos.cliente_id = cliente.id where processos.eta <= CURDATE() and processos.eta != null and (select count(*) from importacoes_anexos where processo=processos.processo and doc =5) > 0 and processos.tipoProcesso = 1 and processos.owner={$by["empresa_id"]}";
        
        return $this->fetch($queryDesembaraco);
    }
    
    public function avisoAtracacao($dias){
        
        $condicaoProcesso = array(
            "conditions"=>array(
                "tipoProcesso"=>"1",
                "embarcado"=>"1",
                "avisoAtracacao"=>"0",
                "eta <="=>date("Y-m-d",  strtotime("+".$dias." days"))
            ),
            "order"=>"created DESC"
        );
        return $this->all($condicaoProcesso);
    }

}

?>
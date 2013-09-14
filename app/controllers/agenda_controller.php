<?php

class agendaController extends AppController {
    
    public $uses = array(
        "agenda_compromissos", "rh_funcionarios"
    );

    public function index() {

    }

    public function compromissos($op, $id=null) {
        switch ($op) {
            case "cadastrar":
                $this->data["cadpor"] = $this->AuthComponent->user("id");
                if ($this->data["funcionario_id"] == 0 or empty($this->data["funcionario_id"])) {
                    $this->data["funcionario_id"] = $this->AuthComponent->user("id");
                }
                $this->agenda_compromissos->save($this->data);
                $this->set("idCompromisso", $this->agenda_compromissos->getInsertId());
                $this->set("op", $op);
                //pr($this->data); //Após testes, comentar ou retirar essa linha
                break;
            case "deletar":
                if ($id != null) {
                    $this->agenda_compromissos->delete($id,false);
                }
                break;
            case "editar":
                if ($id != null) {
                    $this->data["id"] = $id;
                    $this->agenda_compromissos->save($this->data);
                }
                break;
        }
    }

    public function jsonAgenda($id=0) {
        if ($this->AuthComponent->user("permissao") != 1) {
            if ($id == 0 or $id == "undefined") {
                $id = $this->AuthComponent->user("id");
            } elseif ($id != 0 and $id != $this->AuthComponent->user("id")) {
                $verifica = $this->rh_funcionarios->first(array("conditions" => array("id" => $id)));
                if ($this->AuthComponent->user("id") == $verifica["gerente_id"]) {
                    $id = $verifica["id"];
                } else {
                    $id = $id;
                }
            } else {
                $id = $this->AuthComponent->user("id");
            }
        } else {
            if ($id == 0) {
                $id = $this->AuthComponent->user("id");
            }
        }
        $where = array(
            "conditions" => array(
                "funcionario_id" => $id
            ),
            "fields" => array(
                "id",
                "DATE_FORMAT(inicio,'%Y-%m-%dT%H:%i:%s')  as start",
                "DATE_FORMAT(termino,'%Y-%m-%dT%H:%i:%s') as end",
                "observacao as body",
                "titulo as title"
            ),
            "order" => "inicio"
        );
        $this->set("json", $this->agenda_compromissos->all($where));
    }

    public function selectFuncionarios() {
        $where = array(
            "conditions" => array(
                "or" => array(
                    "gerente_id" => $this->AuthComponent->user("id"),
                    "id" => $this->AuthComponent->user("id")
                ),
                "dt_desligamento"=>"0000-00-00"
            ),
            "fields" => array(
                "id",
                "nome"
            ),
            "displayField" => "nome"
        );

        $this->set("funcionarios", $this->rh_funcionarios->toList($where));
    }

    public function exportaOutlook(){
        $this->layout = false;
        
    }

}

?>
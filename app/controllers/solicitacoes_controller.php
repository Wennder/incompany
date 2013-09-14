<?php

class solicitacoesController extends AppController {
    
    public $uses = array(
        "ocorrencia", "rh_funcionarios", "tipodespesa", "financeiro_motivodespesa"
    );

    public function index() {
    
    	$condicaoQtd = array(
    		"conditions"=>array(
    			"gerente"=>$this->AuthComponent->user("id"),
    			"status_id"=>"0"
    		)
    	);
	$this->set("numAprovar",$this->ocorrencia->count($condicaoQtd));
    }

    public function novo() {

        $conditions = array(
            "displayField" => "nome",
            "conditions" => array(
                "or" => array(
                    "id" => $this->AuthComponent->user("id"),
                    "gerente_id" => $this->AuthComponent->user("id")
            ),
            "dt_desligamento" => "0000-00-00"),
            "order" => "nome ASC"
        );

        $whereList = array("displayField" => "nome", "order" => "nome ASC");
        $this->set("beneficiarios", $this->rh_funcionarios->toList($conditions));
        $whereList["conditions"]["ativo"]="1";
        $this->set("tiposDespesa", $this->tipodespesa->toList($whereList));
        $this->set("motivosDespesas",$this->financeiro_motivodespesa->toList($whereList));

        if (!empty($this->data)) {
            $this->data["gerente"]= $this->AuthComponent->user("gerente_id");
            if (!$this->ocorrencia->save($this->data)) {
                $this->redirect("/solicitacoes/");
                $this->setAlert("Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
            } else {
                $protocolo = $this->ocorrencia->getInsertId();
                $this->setAlert("Solicitação de Reembolso Realizada com Sucesso. Protocolo: #".$protocolo);
                $this->redirect("/solicitacoes/");
            }
        }
    }

    public function geradas() {

        if (empty($this->data)) {

            $whereOcorrencias = array(
                "conditions" => array(
                    "beneficiario" => $this->AuthComponent->user("id")
                ),
                "order" => "created DESC"
            );
        } else {
            $this->data["dataInicio"] = $this->FormComponent->dataMysql($this->data["dataInicio"]);
            $this->data["dataFim"] = $this->FormComponent->dataMysql($this->data["dataFim"]);
            $whereOcorrencias = array(
                "conditions" => array(
                    "or" => array(
                        "usuario_id" => $this->AuthComponent->user("id"),
                        "beneficiario" => $this->AuthComponent->user("id")
                    ),
                    "and" => array(
                        "created >=" => $this->data["dataInicio"],
                        "created <=" => $this->data["dataFim"]
                    ),
                    "status_id" => $this->data["status"]
                ),
                "order" => "created DESC"
            );
        }

        $whereGerentes = array(
            "displayField" => "nome",
            "conditions" => array(
                "or" => array(
                    "id" => $this->AuthComponent->user("id"),
                    "gerente_id" => $this->AuthComponent->user("id")
            )),
            "order" => "nome ASC"
        );      

        $this->set("ocorrencias", $this->ocorrencia->all($whereOcorrencias));        
        $this->set("gerentes", $this->rh_funcionarios->toList($whereGerentes));
    }

    public function reembolsoAprovar() {
        $aguardando = array(
            "conditions"=>array(
                "gerente"=>$this->AuthComponent->user("id"),
                "status_id"=>"0"
                )
        );
        $this->set("ocorrenciasAguardo", $this->ocorrencia->all($aguardando));
    }

    public function verReembolso($id=null) {

        if (!empty($this->data)) {
            $this->data["gerente"]=$this->AuthComponent->user("id");
            $this->ocorrencia->save($this->data);
            $this->redirect("/solicitacoes/geradas/");
        }

        $whereOcorrencia = array(
            "conditions" => array(
                "id" => $id
                )
            );
        $this->set("Aocorrencia", $this->ocorrencia->first($whereOcorrencia));
    }
    public function formBuscaReembolso(){
    $whereGerentes = array(
            "displayField" => "nome",
            "conditions" => array(
                "or" => array(
                    "id" => $this->AuthComponent->user("id"),
                    "gerente_id" => $this->AuthComponent->user("id")
            )),
            "order" => "nome ASC"
        );
        
    	$this->set("gerentes",$this->rh_funcionarios->toList($whereGerentes));
    }
    public function novaHoraExtra() {

        $conditionsHora = array(
            "conditions" => array(
                "or" => array(
                    "usuario" => $this->AuthComponent->user("id"),
                    "beneficiario" => $this->AuthComponent->user("id")
            )),
            "order" => "created DESC"
        );

        $conditionsBene = array(
            "displayField" => "nome",
            "conditions" => array(
                "or" => array(
                    "id" => $this->AuthComponent->user("id"),
                    "gerente_id" => $this->AuthComponent->user("id")
            )),
            "order" => "nome ASC"
        );

        if (!empty($this->data)) {

            if (!$this->horaextra->save($this->data)) {

                $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
            }
        }

        $this->set("pedidosHora", $this->horaextra->all($conditionsHora));
        $this->set("beneficiariosHora", $this->rh_funcionarios->toList($conditionsBene));
    }
}

?>
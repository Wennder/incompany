<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class eticketController extends AppController {
    
    public $uses = array(
        "eticket_pedidos", "eticket_respostas", "eticket_status", "rh_setor",
        "rh_funcionarios"
    );

    public function Tickets($op, $id=null) {

        $this->set("op", $op);
        $setor = $this->rh_setor->first(array("conditions" => array("id" => $this->AuthComponent->user("rh_setor_id"))));
        $this->set('emailSetor', $setor["email"]);

        switch ($op) {
            case "novo":
                $this->set("listaDpto", $this->rh_setor->toList(array("order" => "nome ASC", "displayField" => "nome")));
                if (!empty($this->data)) {
                    $setores = $this->rh_setor->toList(array("displayField" => "email"));
                    $this->data["users_id"] = $this->AuthComponent->user("id");
                    $this->eticket_pedidos->save($this->data);
                    $protocolo = $this->eticket_pedidos->getInsertId();
                    $this->set("protocolo", $protocolo);
                    $texto = "Foi aberto uma solicitação para seu departamento: <br/><b>Protocolo:</b> $protocolo<br/><b>Assunto:</b> " . $this->data["assunto"];
                    if ($this->EmailcComponent->sendMailDefault($setores[$this->data["rh_setor_id"]], $texto)) {
                        $this->redirect("/eticket/Tickets/grid");
                    }
                }


                $where = array(
                    "conditions" => array(
                        "id" => $id
                    ),
                );
                $this->set("dados", $this->eticket_pedidos->first($where));
                break;

            //lista todos os tickets abertos
            case"grid":
                $where = array(
                    "conditions" => array(
                        "users_id" => $this->AuthComponent->user("id")
                    ),
                    "order" => "id DESC",
                    "fields" => array("id", "assunto", "created", "status_id", "rh_setor_id")
                );
                $this->set("solicitacoes", $this->eticket_pedidos->all($where));
                break;
                
            case "encaminhadas":
	        $id = $this->AuthComponent->user("rh_setor_id");
	        $setor = $this->rh_setor->first(array("conditions" => array("id" => $id)));
	        $this->set('emailSetor', $setor["email"]);
	
	        $statusAberto = $this->eticket_status->all(array("fields"=>array("id"),"conditions"=>array("emAberto"=>"1", "rh_setor_id"=>$id)));
	        
	        $this->set("status", $this->eticket_status->toList(array("conditions" => array("id" => $id), "displayField" => "nome")));
	        $this->set("funcionarios", $this->rh_funcionarios->toList(array("displayField" => "nome")));
	
	        $whereSimples = array(
	            "conditions" => array(
	                "rh_setor_id" => $this->AuthComponent->user("rh_setor_id"),
	                "responsavel" => $this->AuthComponent->user("id"),
	                "status_id"=>$statusAberto
	            ),
	            "order" => "id DESC"
	        );
	
	        $whereGerente = array(
	            "conditions" => array(
	                "rh_setor_id" => $this->AuthComponent->user("rh_setor_id"),
	                "status_id"=>$statusAberto
	            ),
	            "order" => "id DESC"
	        );
	
	        if ($this->verificaGenrencia()) {
	            $whereSelecionado = $whereGerente;
	            
	        } else {
	            $whereSelecionado = $whereSimples;
	            
	        }
	        $this->set("chamadosEticket", $this->eticket_pedidos->all($whereSelecionado));
            break;


            //aqui eh o acompnhamento dos tiketss
            case "ver":

                if ($this->eticket_pedidos->exists($id)) {
                    $this->set("listaStatus", $this->eticket_status->toList(array(
                                "conditions" => array(
                                    "rh_setor_id" => $this->AuthComponent->user("rh_setor_id")
                                ),
                                "order" => "nome ASC",
                                "displayField" => "nome"
                                    )
                            )
                    );


                    $this->set("comboResponsavel", $this->rh_funcionarios->toList(array(
                                "conditions" => array(
                                    "rh_setor_id" => $this->AuthComponent->user("rh_setor_id")
                                ),
                                "order" => "nome ASC",
                                "displayField" => "nome"
                            )));


                    if (!empty($this->data)) {
                        if (!empty($this->data["status_id"]) || !empty($this->data["previsao"])) {
                            $dt_previsao = strtotime($this->data["previsao"]);

                            if (empty($this->data["responsavel"])) {
                                $this->data["responsavel"] = $this->AuthComponent->user("id");
                            }

                            $dadoChamado = array(
                                "id" => $id,
                                "status_id" => $this->data["status_id"],
                                "responsavel" => $this->data["responsavel"],
                                "previsao" => date("Y-m-d", $dt_previsao)
                            );
                            $this->eticket_pedidos->save($dadoChamado);
                        }



                        $this->data["users_id"] = $this->AuthComponent->user("id");
                        $this->data["sys_solicitacoes_id"] = $id;
                        $this->data['previsao'] = date("Y-m-d", $dt_previsao);
                        $this->eticket_respostas->save($this->data);
                    }

                    $whereSol = array(
                        "conditions" => array(
                            "id" => $id
                        )
                    );
                    $this->set("solicitacao", $this->eticket_pedidos->first($whereSol));
                    $this->set("status", $this->eticket_status->toList(array("displayField" => "nome")));
                    $this->set("funcionarios", $this->rh_funcionarios->toList(array("displayField" => "nome")));
                } else {
                    $this->redirect("/eticket/Tickets/grid");
                }
                break;
            case "responder":
                $whereSimples = array(
                    "conditions" => array(
                        "rh_setor_id" => $this->AuthComponent->user("rh_setor_id"),
                        "responsavel" => $this->AuthComponent->user("id")
                    ),
                    "order" => "id DESC"
                );

                $whereGerente = array(
                    "conditions" => array(
                        "rh_setor_id" => $this->AuthComponent->user("rh_setor_id")
                    ),
                    "order" => "id DESC"
                );

                if (substr_count($setor["email"], $this->AuthComponent->user("username")) > 0) {
                    $whereSelecionado = $whereGerente;
                } else {
                    $whereSelecionado = $whereSimples;
                }

                $this->set("responder", $this->eticket_pedidos->all($whereSelecionado));
                break;
        }
    }

    public function status($op, $id=null) {

        $setor = $this->rh_setor->first(array("conditions" => array("id" => $this->AuthComponent->user("rh_setor_id"))));
        if ($setor["email"] != $this->AuthComponent->user("username")) {
            echo "<b>".$this->AuthComponent->errorPermission."</b>";
            die;
        }

        $this->set("op", $op);
        switch ($op) {
            case "novo":
                $this->set("listaDpto", $this->rh_setor->toList(array("order" => "nome ASC", "displayField" => "nome")));
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->data["rh_setor_id"] = $this->AuthComponent->user("rh_setor_id");
                    if ($this->eticket_status->save($this->data)) {
                        $this->setAlert("Salvo com sucesso");
                    } else {
                        $this->setAlert("Não foi possivel salvar, tente novamente");
                    }
                    $this->redirect("/solicitacoes/");
                }
                break;
            case "editar":
                $this->redirect("/solicitacoes/");
                break;

            case "grid":
                $wheregrid = array(
                    "fields" => array(
                    	"id",
                        "nome",
                        "emAberto"
                    ),
                    "conditions" => array(
                        "rh_setor_id" => $this->AuthComponent->user("rh_setor_id")
                    )
                );
                $this->set("statuGrid", $this->eticket_status->all($wheregrid));

                $where = array(
                    "conditions" => array(
                        "id" => $id
                        ));
                $this->set("dados", $this->eticket_status->first($where));
                break;

            case"del":
                $this->eticket_status->delete($id);
                break;
        }
    }

    public function dashBoard() {
        $id = $this->AuthComponent->user("rh_setor_id");
        $setor = $this->rh_setor->first(array("conditions" => array("id" => $id)));
        $this->set('emailSetor', $setor["email"]);

        $statusAberto = $this->eticket_status->all(array("fields"=>array("id"),"conditions"=>array("emAberto"=>"1")));
        
        $this->set("status", $this->eticket_status->toList(array("conditions" => array("id" => $id), "displayField" => "nome")));
        $this->set("funcionarios", $this->rh_funcionarios->toList(array("displayField" => "nome")));

        $whereSimples = array(
            "conditions" => array(
                "rh_setor_id" => $this->AuthComponent->user("rh_setor_id"),
                "responsavel" => $this->AuthComponent->user("id"),
                "status_id"=>$statusAberto
            ),
            "order" => "id DESC"
        );

        $whereGerente = array(
            "conditions" => array(
                "rh_setor_id" => $this->AuthComponent->user("rh_setor_id"),
                "status_id"=>$statusAberto
            ),
            "order" => "id DESC"
        );

        if (substr_count($setor["email"], $this->AuthComponent->user("username")) > 0) {
            $whereSelecionado = $whereGerente;
            $wherePrevisao = array(
                "conditions" => array(
                    "rh_setor_id" => $this->AuthComponent->user("rh_setor_id"),
                    "previsao <=" => date("Y-m-d"),
                    "status_id"=>$statusAberto
                ),
                "order" => "previsao ASC"
            );
        } else {
            $whereSelecionado = $whereSimples;
            $wherePrevisao = array(
                "conditions" => array(
                    "rh_setor_id" => $this->AuthComponent->user("rh_setor_id"),
                    "responsavel" => $this->AuthComponent->user("id"),
                    "previsao <=" => date("Y-m-d"),
                    "status_id"=>$statusAberto
                ),
                "order" => "previsao ASC"
            );
        }

        $this->set("chamadosEticket", $this->eticket_pedidos->all($whereSelecionado));



        $this->set("chamadosPrevisao", $this->eticket_pedidos->all($wherePrevisao));
    }

}
?>
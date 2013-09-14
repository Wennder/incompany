<?php

/**
 * Classe Home, controla todo conteúdo a ser enviado para as views da Home.
 */
class HomeController extends AppController {

    public $uses = array(
        "admin_avisos", "rh_funcionarios", "agenda_compromissos"
    );

    /**
     * Função que controla Index do Sistema
     */
    public function index($op) {
        $this->set("op", $op);
        switch ($op) {
            default:
            case "index":

                break;

            case "trocarSenha":
                if (!empty($this->data)) {
                    $validacao = $this->ValidationComponent
                            ->field("senhaAtual")->required()
                            ->field("password")->equalTo("confirmPassword")->required()->between(8, 20)
                            ->isValid();
                    if($validacao){
                        $this->rh_funcionarios->save($this->data);
                    }
                }
                break;
        }

//        $where = array(
//            "conditions" => array(
//                "or" => array(
//                    "rh_setor_id" => array("0", $this->AuthComponent->user("rh_setor_id"))
//                )
//            ),
//            "limit" => "5",
//            "order" => "created DESC"
//        );
//
//        $this->set("avisos", $this->admin_avisos->all($where));
//        $whereCompromissos = array(
//            "fields"=>array(
//                "day(inicio) as dia",
//                "count(*) as qtd"
//                ),
//            "conditions"=>array(
//                "funcionario_id"=>$this->AuthComponent->user("id"),
//                "month(inicio)"=>date("m"),
//                "year(inicio)"=>date("Y")
//            ),
//            "groupBy"=>"dia"
//        );
//        $this->set("compromissos",$this->agenda_compromissos->all($whereCompromissos));
    //
    }

    /**
     * Home de teste
     */
    public function beta() {
        $where = array(
            "conditions" => array(
                "or" => array(
                    "rh_setor_id" => array("0", $this->AuthComponent->user("rh_setor_id"))
                )
            ),
            "limit" => "5",
            "order" => "created DESC"
        );

        $this->set("avisos", $this->admin_avisos->all($where));

        $whereAviversariantes = array(
            "conditions" => array(
                "sysEmpresas_id" => $this->AuthComponent->user("sysEmpresas_id"),
                "month(dt_nascimento)" => date("m"),
                "dt_desligamento" => "0000-00-00"
            ),
            "fields" => array(
                "CONCAT_WS('-',day(dt_nascimento),nome) as titulo"
            ),
            "order" => "day(dt_nascimento)"
        );

        $this->set("aniversariantes", $this->rh_funcionarios->all($whereAviversariantes));
    }

    /**
     * Pop-under de ler aviso da Home
     * @param int $id
     */
    public function lerMensagem($id) {
        $this->layout = false;
        $where = array(
            "conditions" => array(
                "id" => $id
            )
        );
        $this->set("aviso", $this->admin_avisos->first($where));
    }

    /**
     *
     * @param string $op Define que tipo de Operação será executada
     * @param int $id Define o Id do funcionário
     */
    public function agendaFuncionarios($op = null, $id = null) {

        if (isset($this->data["nome"])) {
            $where = array(
                "order" => "nome ASC",
                "perPage" => 1,
                "page" => $this->page(),
                "fields" => array(
                    "id",
                    "nome",
                    "username",
                    "tel",
                    "cel"
                ),
                "conditions" => array(
                    "nome LIKE" => "%" . $this->data["nome"] . "%"
                )
            );
            $this->set("dadosFuncionario", $this->rh_funcionarios->all($where));
        } elseif ($id != null) {
            $where = array("conditions" => array("id" => $id));
            $this->set("dadosFuncionario", $this->rh_funcionarios->all($where));
            $this->set("op", $op);
        }
    }

    public function novaSolicitacao() {
        if (!empty($this->data)) {
            $this->data["users_id"] = $this->AuthComponent->user("id");
            $this->eticket_pedidos->save($this->data);
            $this->set("protocolo", $this->eticket_pedidos->getInsertId());
        }
    }

    public function minhasSolicitacoes() {
        $where = array(
            "conditions" => array(
                "users_id" => $this->AuthComponent->user("id")
            ),
            "order" => "id DESC",
            "fields" => array("id", "rh_setor_id", "assunto", "status_id", "created")
        );
        $this->set("solicitacoes", $this->eticket_pedidos->all($where));
    }

    /**
     *
     * @param int $id Define qual a ID da solicitação a ser visualizada
     */
    public function verSolicitacao($id) {

        if (!empty($this->data)) {
            $this->data["users_id"] = $this->AuthComponent->user("id");
            $this->data["sys_solicitacoes_id"] = $id;
            $this->sys_respsolicitacoes->save($this->data);
            unset($this->data);
            $this->data["id"] = $id;
            $this->data["status_id"] = "0";
            $this->eticket_pedidos->save($this->data);
        }

        $whereSol = array(
            "conditions" => array(
                "id" => $id,
                "users_id" => $this->AuthComponent->user("id")
            )
        );
        $this->set("solicitacao", $this->sys_solicitacoes->first($whereSol));

        $where = array(
            "conditions" => array(
                "sys_solicitacoes_id" => $id
            ),
            "order" => "id DESC"
        );

        $this->set("respostas", $this->sys_respsolicitacoes->all($where));
    }

    public function image() {
        $this->layout = false;
        $params = array(
            "height" => $_GET["h"],
            "width" => $_GET["w"],
            "constrain" => true,
            "quality" => 80,
            "view" => true
        );
        $this->ImageComponent->resize("webroot/images/" . $_GET["i"], $params);
        $this->layout = null;
    }

    public function cadCartaoVV() {
        if (!empty($this->data)) {
            $this->data["id"] = $this->AuthComponent->user("id");
            $this->rh_funcionarios->save($this->data);
            $this->redirect("/");
        }
    }

}

?>
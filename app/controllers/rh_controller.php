<?php

class rhController extends AppController {
    
    public $uses = array(
        "rh_funcionarios","rh_setor","rh_docs","rh_dependentes","SysGrupoEmpresa",
        "sys_empresas","financeiro_bancos"
    );

    public function index() {
        //$this->redirect("/rh/cadFuncionario");
    }

    public function cadFuncionario($id=null) {

        if (!empty($this->data)) {
            $this->data["nome"] = ucwords(strtolower($this->data["nome"]));
            //Inicio formataçao de data
            if (!empty($this->data["dt_admissao"]) && $this->data["dt_admissao"] != "00-00-0000") {
                $dt_admissao = strtotime($this->data["dt_admissao"]);
                $this->data["dt_admissao"] = date("Y-m-d", $dt_admissao);
            }
            //fim formatação
            if (!empty($this->data["dt_desligamento"]) && $this->data["dt_desligamento"] != "00-00-0000") {
                $dt_desligamento = strtotime($this->data["dt_desligamento"]);
                $this->data["dt_desligamento"] = date("Y-m-d", $dt_desligamento);
            }
            //fim outra formatação
            if (!empty($this->data["dt_nascimento"]) && $this->data["dt_nascimento"] != "00-00-0000") {
                $dt_nascimento = strtotime($this->data["dt_nascimento"]);
                $this->data["dt_nascimento"] = date("Y-m-d", $dt_nascimento);
            }
            //fim
            
            if (!$this->rh_funcionarios->save($this->data)) {
                $aviso = "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.";
                $url = "/rh/gridFuncionario";
            } else {

                if (empty($this->data["id"])) {
                    $idFunc = $this->rh_funcionarios->getInsertId();
                } else {
                    $idFunc = $this->data["id"];
                }
                $aviso = "Registro Salvo com Sucesso!";
                $url = "/rh/cadFuncionario/" . $idFunc;
            }
            $this->setAlert($aviso);
            $this->redirect($url);
        }

        $this->set("dadosUsuario", $this->rh_funcionarios->firstById($id));

        $condicaoPadrao = array("displayField" => "nome", "order" => "nome ASC","conditions"=>array("dt_desligamento"=>"0000-00-00"));

        $this->set("gerentes", $this->rh_funcionarios->toList($condicaoPadrao));
        $condicaoPadrao["conditions"]="";
        $this->set("perfis", $this->rh_setor->toList($condicaoPadrao));
        $this->set("bancos", $this->financeiro_bancos->toList($condicaoPadrao));
        $this->set("grupoEmpresa", $this->SysGrupoEmpresa->toList(array("displayField" => "nome")));
    }

    public function preCadastroFuncionario() {
        if (!empty($this->data)) {
            $this->data["nome"]=ucwords($this->data["nome"]);
            //fim outra formatação
            if (!empty($this->data["dt_nascimento"]) && $this->data["dt_nascimento"] != "00-00-0000") {
                $dt_nascimento = strtotime($this->data["dt_nascimento"]);
                $this->data["dt_nascimento"] = date("Y-m-d", $dt_nascimento);
            } else {
                unset($this->data["dt_nascimento"]);
            }
            //fim
            if (!$this->rh_funcionarios->save($this->data)) {
                $aviso = "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.";
                $url = "/rh/gridFuncionario";
            } else {

                if (empty($this->data["id"])) {
                    $idFunc = $this->rh_funcionarios->getInsertId();
                } else {
                    $idFunc = $this->data["id"];
                }
                $aviso = "Registro Salvo com Sucesso!";
                $url = "/rh/cadastrosPendentes/";
            }
            $this->setAlert($aviso);
            $this->redirect($url);
        }

        $where = array("conditions" => array("id" => $id));
        $this->set("dadosUsuario", $this->rh_funcionarios->first($where));

        $condicaoPadrao = array("displayField" => "nome", "order" => "nome ASC");

        $this->set("gerentes", $this->rh_funcionarios->toList($condicaoPadrao));
        $this->set("perfis", $this->rh_setor->toList($condicaoPadrao));
        $this->set("bancos", $this->financeiro_bancos->toList($condicaoPadrao));
        $this->set("grupoEmpresa", $this->SysGrupoEmpresa->toList(array("displayField" => "nome")));
    }

    public function cadastrosPendentes() {

        $where = array(
            "order" => "sysEmpresas_id, nome ASC",
            "perPage" => 1,
            "page" => $this->page(),
            "fields" => array(
                "id",
                "nome",
                "dt_desligamento",
                "grupoEmpresa_id",
                "sysEmpresas_id",
                "username"
            ),
            "conditions" => array(
                "grupoEmpresa_id" => $this->AuthComponent->user("grupoEmpresa_id"),
                "dt_admissao" => "0000-00-00"
            )
        );


        $this->set("dadosUsuarios", $this->rh_funcionarios->all($where));
    }

    public function resetSenha($id) {
        $this->data["id"] = $id;
        $this->data["password"] = "";
        $this->rh_funcionarios->save($this->data);
        $this->redirect("/rh/cadFuncionario/" . $id);
    }

    public function selectEmpresa($grupo=null, $valor=null) {

        $this->set("SelEmpresa", $this->sys_empresas->toList(array("displayField" => "nomeFantasia", "conditions" => array("grupoEmpresa_id" => $grupo))));
        $this->set("valor", $valor);
    }

    public function delFuncionario($id) {

        $this->rh_funcionarios->delete($id);
        $this->redirect("/rh/gridFuncionario");
    }

    public function gridFuncionario() {

        if (isset($this->data["nome"])) {
            $where = array(
                "order" => "sysEmpresas_id, nome ASC",
                "perPage" => 1,
                "page" => $this->page(),
                "fields" => array(
                    "id",
                    "nome",
                    "grupoEmpresa_id",
                    "sysEmpresas_id",
                    "cargo",
                    "dt_desligamento"
                ),
                "conditions" => array(
                    "nome LIKE" => "%" . $this->data["nome"] . "%",
                    "grupoEmpresa_id" => $this->AuthComponent->user("grupoEmpresa_id")
                )
            );
        } else {
            $where = array(
                "order" => "sysEmpresas_id, nome ASC",
                "perPage" => 1,
                "page" => $this->page(),
                "fields" => array(
                    "id",
                    "nome",
                    "grupoEmpresa_id",
                    "sysEmpresas_id",
                    "cargo",
                    "dt_desligamento"
                ),
                "conditions" => array(
                    "grupoEmpresa_id" => $this->AuthComponent->user("grupoEmpresa_id")
                )
            );
        }
        switch($this->data["estado"]){
            case 0:
                break;
            case 1:
                $where["conditions"]["dt_desligamento"] = "0000-00-00";
                break;
            case 2:
                $where["conditions"]["dt_desligamento !="] = "0000-00-00";
                break;
                
        }

        $this->set("dadosUsuarios", $this->rh_funcionarios->all($where));
    }

    public function cadDependente($id=null, $op=null) {
        $this->layout = false;

        $where = array("conditions" => array("users_id" => $id));
        $this->set("dependentesCad", $this->rh_dependentes->all($where));

        $this->set("funcionario", $id);
        $this->set("op", $op);
        if (!empty($this->data)) {
            $nascimento = strtotime($this->data["nascimento"]);
            $this->data["nascimento"] = date("Y-m-d", $nascimento);
            if (!$this->rh_dependentes->save($this->data)) {
                $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
            }
        }
    }

    public function delDependente($id) {
        $this->rh_dependentes->delete($id);
    }

    public function cadDocumento($id=null, $op=null) {
        $this->set("donoDoc", $id);
        if (!empty($_FILES)):
            $tipo = $this->data["tipoDoc"];
            $dono = $this->data["users_id"];
            $numero = $this->data["desc"];
            $this->UploadComponent->path = "/images/rh/$id/";
            $file = $this->UploadComponent->files["file"]; //o erro praticamente estava aqui
            $filename = $this->AuthComponent->createPassword() . "." . $this->UploadComponent->ext($file);
            $upload = $this->UploadComponent->upload($file, null, $filename);
            if ($upload) {
                unset($this->data);
                $this->data["file"] = $this->UploadComponent->path . $filename;
                $this->data["users_id"] = $dono;
                $this->data["number"] = $numero;
                $this->data["tipoDoc"] = $tipo;

                if (!$this->rh_docs->save($this->data)) {
                    $this->setAlert("Houve um problema em sua requisição, tente novamente");
                }
            } else {
                $this->set("erro", $this->UploadComponent->uploadError());
            }
        endif;

        $where = array("conditions" => array("users_id" => $id));
        $this->set("docsIn", $this->rh_docs->all($where));
        $this->set("op", $op);
    }

    public function delDocumento($id) {
        if (!empty($id)) {
            $url = $this->rh_docs->first(array("conditions" => array("id" => $id)));
            unlink(APP . DS . "webroot" . $url["file"]);
            $this->rh_docs->delete($id);
        }
    }

    public function verDoc($id=null) {
        $where = array("conditions" => array("id" => $id));
        $this->set("docs", $this->rh_docs->first($where));
    }

    public function fichaFuncionario($id=null) {
        $this->layout = false;
        $where = array("conditions" => array("id" => $id));
        $this->set("dadoFunc", $this->rh_funcionarios->first($where));
    }

    public function printFichaCompleta($id) {
        $where = array("conditions" => array("id" => $id));
        $this->set("dadoFuncionario", $this->rh_funcionarios->first($where));
    }

    public function cadDepartamento($id=null) {

        $this->set("nivelpermissao", $this->sys_permissoes->toList(array("order" => "nome ASC", "displayField" => "nome")));
        if (!empty($this->data)) {
            $this->data["sysEmpresas_id"] = $this->AuthComponent->user('sysEmpresas_id');
            if (!$this->rh_setor->save($this->data)) {

                $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
            } else {
                $this->setAlert("Salvo com Sucesso!");
            }
        }



        $where = array("order" => "nome ASC");
        $this->set("listSetor", $this->rh_setor->all($where));
    }

    public function delDepartamento($id) {

        if (!$this->rh_setor->delete($id)) {

            $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
        }
        $this->redirect("/rh/cadDepartamento");
    }

    public function equipe() {
        $where = array(
            "conditions" => array(
                "gerente_id" => $this->AuthComponent->user("id"),
                "dt_desligamento"=>"0000-00-00"
                
            )
        );

        $this->set("equipe", $this->rh_funcionarios->all($where));
    }

    public function relatorios($op, $id) {
        $this->set("op", $op);
        switch ($op) {
            case "formAniversariantes":
                $this->layout = false;
                if(!empty($this->data)){
                    $this->redirect("/rh/relatorios/aniversariantesMes/".$this->data["mes"]);
                }
                break;
            case "aniversariantesMes":
                $condicao = array(
                    "conditions" => array(
                        "month(dt_nascimento)" => $id,
                        "dt_desligamento"=>"0000-00-00"
                    ),
                    "fields" => array("nome", "dt_nascimento"),
                    "order"=>"day(dt_nascimento)"
                );
                $this->set("dadosGrid", $this->rh_funcionarios->all($condicao));
                break;
        }
    }

}
?>
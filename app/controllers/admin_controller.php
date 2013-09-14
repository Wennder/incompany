<?php

class adminController extends AppController {

    public $uses = array(
        "admin_avisos",
        "admin_config",
        "sys_permissoes",
        "sys_empresas",
        "SysGrupoEmpresa",
        "rh_setor",
        "rh_funcionarios",
        "sys_moedas",
        "sys_ncm",
        "sys_cfop",
        "sys_aliqsinternas",
        "sys_modulos",
        "sys_paginas"
    );
    public $moduloID = 1;

    /**
     * Para que você não receba o erro de Model não existente, o HomeController
     * está configurado para não usar modelo algum. Basta remover a linha abaixo
     * e ele passará a se comportar da forma que você espera.
     */
    //public $uses = array("rh_setor","users" ,"tipodespesa", "financeiro_motivodespesa");

    public function index() {
        
    }

    public function mainConfig($op) {
        
        $this->set("op",$op);
        switch($op){
            case "email":
                $IDConf = 100;
                if(!empty($this->data)){
                    $this->data["modulo"] = $this->moduloID;
                    $this->data["config"] = $IDConf;
                    if($this->admin_config->save($this->data)){
                        die("Salvo com Sucesso");
                    }else{
                        die("Ocoreu um Erro");
                    }
                }
                $this->set("dadosForm",$this->admin_config->getConfig($this->moduloID,$IDConf));
                break;
            default:
            case "index":
                
                break;
        }
    }

    public function cadAviso() {
        if (!empty($this->data)) {
            if (!$this->admin_avisos->save($this->data)) {
                $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
                $this->redirect("/admin/");
            }
            $this->redirect("/admin/");
        }

        $this->set("listDepartamentos", $this->rh_setor->toList(array("displayField" => "nome", "order" => "nome ASC")));
    }

    public function nivelPermissoes() {
        if (!empty($this->data)) {
            if (!$this->admin_permissoes->save($this->data)) {

                $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
            }
        }

        $where = array("order" => "id ASC");
        //$this->set("permissoes", $this->admin_permissoes->all($where));
    }

    /*
     * @param Id da empresa que será editada, parametro não obrigatório.
     * @return Redireciona para /admin/empresas
     */

    public function novaEmpresa($id = null) {
        if (!empty($this->data)) { // vereifico se esta vazio
            $this->data['id'] = $id; //gravo meu id em uma variavel chamada id
            if ($this->sys_empresas->save($this->data)) {//gravo os dados na minha tabela sys_empresas, $this->data é todos os campos do meu form, para especificar eu como entre conchetres onme do campo
                $this->setAlert("Registro Salvo com Sucesso");
                $this->redirect("/admin/");
            }
        }
        $this->set("dados", $this->sys_empresas->first(array("conditions" => array("id" => $id)))); //mostro meus dados nos meus campos do formulario
        $this->set("grupo", $this->SysGrupoEmpresa->toList(array("displayField" => "nome")));
    }

    /*
     * @return dados das empresas cadastradas.
     */

    public function empresas() {
        $where = array(
            "order" => "nomeFantasia ASC",
            "fields" => array(
                "nomeFantasia",
                "cnpj",
                "cidade",
                "created",
                "id"
            )
        );

        $this->set("dadosGrid", $this->sys_empresas->all($where));
    }

    public function grupoEmpresas($op = "grid", $id = null) {
        $this->set("op",$op);
        switch ($op) {
            default:
            case "grid":
                $where = array(
                    "order" => "nome ASC",
                    "fields" => array(
                        "nome",
                        "id"
                    )
                );

                $this->set("dadosGrid", $this->SysGrupoEmpresa->all($where));
                break;

            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    if ($this->SysGrupoEmpresa->save($this->data)) {
                        $this->setAlert("Registro Salvo com Sucesso");
                        $this->redirect("/admin/");
                    }
                }
                $this->set("dadosForm", $this->SysGrupoEmpresa->firstById($id));
                break;

            case "deletar":
                $this->SysGrupoEmpresa->delete($id);
                break;
        }
    }

    public function permissoes($op = "grid", $id) {
        $this->set("op", $op);

        switch ($op) {
            case "novo":
                $this->set("paginas", $this->AuthComponent->permissions);

                if (!empty($this->data)) {
                    $this->data['id'] = $id;
                    $pag = $this->data["pagina"];
                    unset($this->data["pagina"]);
                    foreach ($pag as $pagina) {
                        $this->data["paginas"] .= ',' . $pagina;
                    }
                    if ($this->sys_permissoes->save($this->data)) {
                        $this->setAlert("Registro salvo com sucesso!");
                        $this->redirect("/admin/");
                    } else {
                        $this->setAlert("Houve um erro em sua requsição, certifique-se se essa permissão ja existe!");
                    }
                }
                $where = array(
                    "conditions" => array(
                        "id" => $id
                    )
                );
                $this->set("dadosForm", $this->sys_permissoes->first($where));
                break;

            case "grid":
                $where = array(
                    "order" => "nome ASC",
                    "fields" => array(
                        "id",
                        "nome",
                        "created",
                        "modified",
                    )
                );

                $this->set("gridPermissoes", $this->sys_permissoes->all($where));

                break;
            case "deletar":
                $this->sys_permissoes->delete($id);
                $this->redirect("/admin/");

                break;
            default:
                break;
        }
    }

    public function moedas($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "fields" => array(
                        "id",
                        "codigo",
                        "nome"
                    )
                );

                $this->set("dadosGrid", $this->sys_moedas->all($condicao));

                break;
            case "cadastrar":
                if (!empty($this->data)) {

                    $this->data["id"] = $id;
                    $this->data["codigo"] = strtoupper($this->data["codigo"]);

                    if ($this->sys_moedas->save($this->data)) {
                        $this->redirect("/admin");
                    } else {
                        $this->setAlert("Ocorreu algum erro na sua requisição ao Banco de dados");
                        $this->redirect("/admin");
                    }
                }
                $this->set("dadosFormulario", $this->sys_moedas->firstById($id));

                break;
            case "deletar":
                $this->sys_moedas->delete($id);
                $this->redirect("/admin");
                break;
        }
    }

    public function resetVisitas() {
        $this->layout = false;
        if (!$this->rh_funcionarios->fetch("update rh_funcionarios set primeiroAcesso = 0 where primeiroAcesso = 1 AND id >0;")) {
            echo "<div class=\"ui-widget\">
				<div style=\"padding: 0 .7em;\" class=\"ui-state-highlight ui-corner-all\"> 
					<p><span style=\"float: left; margin-right: .3em;\" class=\"ui-icon ui-icon-info\"></span>
					<strong>=D </strong>Reset realizado com sucesso!</p>
				</div>
			</div>";
        } else {
            echo "<div class=\"ui-widget\">
				<div style=\"padding: 0 .7em;\" class=\"ui-state-error ui-corner-all\"> 
					<p><span style=\"float: left; margin-right: .3em;\" class=\"ui-icon ui-icon-info\"></span>
					<strong>Ooops, </strong> Ocorreu algum erro!</p>
				</div>
			</div>";
        }
    }

    public function ncm($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(),
                    "limit" => "10",
                    "order" => "ncm ASC"
                );
                if (!empty($this->data)) {
                    $condicao["conditions"] = array(
                        "ncm" => $this->data["ncm"]
                    );
                }
                $this->set("dadosGrid", $this->sys_ncm->all($condicao));

                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->sys_ncm->save($this->data);
                }
                $this->set("dadosForm", $this->sys_ncm->firstById($id));
                break;
            case "deletar":
                $this->sys_ncm->delete($id);
                break;
        }
    }

    public function cfop($op, $id) {
        $this->set("op", $op);
        switch ($op) {
            default:
            case "grid":
                $this->set("dadosGrid", $this->sys_cfop->all());
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->sys_cfop->save($this->data);
                }
                break;
            case "deletar":
                $this->sys_cfop->delete($id);
                break;
        }
    }
    
    public function modulos($op,$id){
        $this->set("op",$op);
        
        switch ($op) {
            case "cadastrar":
                if(!empty($this->data)){
                    $this->data["id_modulo"] = $id;
                    if($this->sys_modulos->save($this->data)){
                        die("Salvo com Sucesso");
                    }else{
                        die("Ocorreu um Erro, verifique com o Administrador");
                    }
                }
                $this->set("dadosForm",$this->sys_modulos->firstById($id));
                break;

            default:
                case "grid":
                    $condicao = array(
                        "order"=>"nome"
                    );
                    $this->set("dadosGrid",$this->sys_modulos->all($condicao));
                break;
        }
    }
    
    public function paginas($op,$id){
        $this->set("dadosGrid",$this->sys_paginas->all());
    }

}

?>
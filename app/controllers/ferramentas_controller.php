<?php
class ferramentasController extends AppController {
    
    public $uses = array(
        "ocorrencia","financeiro_bancos", "agenda_contatos", "rh_funcionarios",
        "comercial_clientes", "tecnica_intervencao"
    );

    public function index(){
    	
    }

    public function updateGerente() {
    ini_set("display_errors",1);
        $this->layout = false;
        $solicitacoes = $this->ocorrencia->all();

        foreach ($solicitacoes as $solicitacao) {
            $dado["id"] = $solicitacao["id"];
            $dado["gerente"] = $solicitacao["rh_funcionarios"]["gerente_funcionario"]["id"];
            $dado["modified"] = $solicitacao["modified"];
            if ($this->ocorrencia->save($dado)) {
                echo $solicitacao["id"] . " - OK </br>";
            } else {
                echo $solicitacao["id"] . " - Fail </br>";
            }
            unset($dado);
        }
    }

    public function optionsSelect($model, $displayField, $campo, $condicao){
        $this->layout = false;
        echo $this->FormComponent->options($model, $displayField, $campo, $condicao);
    }

    public function optionsBoletoBanco($cedente){
        $this->layout = false;
        $queryBancos = "SELECT c.id, b.nome from financeiro_bancos b inner join financeiro_confBoleto c on c.cod_banco = b.id where c.id_empresa = $cedente";
        $this->set("bancos",$this->financeiro_bancos->fetch($queryBancos));

    }

    public function agendaContato($op, $id=null) {
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                $this->layout = false;
                if (!empty($this->data)) {
                    $this->data['id'] = $id;
                    $this->data['sysEmpresas_id'] = $this->AuthComponent->user("sysEmpresas_id");
                    if ($this->agenda_contatos->save($this->data)) {
                        $this->setAlert("O contato foi salvo, na agenda com Sucesso!");
                        $this->redirect("/ferramentas/agendaContato/");
                    } else {
                        $this->setAlert("Não foi possivel salvar o Contato, tente novamente!");
                        $this->redirect("/ferramentas/agendaContato/");
                    }
                }
                $this->set("dadosAgenda", $this->agenda_contatos->firstById($id));
                break;

            case "grid":
                $this->layout = false;

                $where = array(
                    "order" => "empresa ASC",
                    "limit"=>"15"
                );
                if (!empty($this->data)){
                    $where['conditions']=array(
                        $this->data['field']." LIKE"=>"%".$this->data['value']."%"
                    );
                }
                $this->set("dadosGrid", $this->agenda_contatos->all($where));
                break;
            case "deletar":
                $this->agenda_contatos->delete($id);
                break;

            case "ver":
                $this->layout = false;
                $this->set("dadosAgenda",$this->agenda_contatos->firstById($id));
                break;
        }
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
    
    public function intervencaoFiscal($op="formBusca",$RO,$id){
    $this->set("op",$op);
    $this->set("readOnly",($RO == "s")?true:false);
    if ($this->AuthComponent->user("interventor") == 0){
    die("<b>Você não possui permissão para esse módulo</b>");
    }
    $condicaoClientes = array(
    	"order"=>"razaoSocial",
    	"displayField"=>"razaoSocial"
    	);
    $this->set("listClientes",$this->comercial_clientes->toList($condicaoClientes));
    
    switch($op){
    case "form":
    	if(!empty($this->data)){
    	   $this->data["funcionario_id"] = $this->AuthComponent->user("id");
    	   $this->tecnica_intervencao->save($this->data);
    	}
    	$this->set("dadosForm",$this->tecnica_intervencao->firstById($id));
    break;
    case "formBusca":
    	
    break;
    
    case "grid":
    	
    	$condicao = array(
	    	"order"=>"id DESC",
	    	"limit"=>"10",
	    	"fields"=>array(
	    		"id","nFormulario",
	    		"id_cliente",
	    		"funcionario_id"
	    		),
	    	"conditions"=>array()
	    );
    	
    	if(!empty($this->data)){    	
    		if ($this->data["id_formulario"] > 0){
    			$condicao["conditions"] = array_merge($condicao["conditions"],array("nFormulario"=>$this->data["id_formulario"]));
    		}
    		if($this->data["id_cliente"] > 0){
    		
    			$condicao["conditions"] = array_merge($condicao["conditions"],array("id_cliente"=>$this->data["id_cliente"]));
    		}
    	}
    	$this->set("dadosGrid",$this->tecnica_intervencao->all($condicao));
    break;
    
    case "imprimirMatricial":
        //aqui
    break;
    }
    }

}

?>
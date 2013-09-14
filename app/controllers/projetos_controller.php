<?php

    Class ProjetosController extends AppController
    {
        public $uses = array(
            "projetos_projeto", "projetos_atividades", "projetos_milestones",
            "comercial_clientes", "agenda_compromissos", "rh_setor"
        );
        public function index(){
            
            //Monta Listagem dos projetos em Andamento
            $sqlAndamento = "select pr.id, pr.nome from projetos_projeto as pr right join projetos_atividades as at on at.projetos_projeto_id = pr.id where at.ativo=1 and at.responsavel={$this->loggedUser["id"]} limit 3;";
            $this->set("emAndamento", $this->projetos_projeto->fetch($sqlAndamento));
            
            $sqlPtoControle = "select mi.id, mi.nome, mi.previsao from projetos_milestones as mi right join projetos_atividades as at on at.projetos_milestones_id = mi.id where at.ativo = 1 and at.responsavel={$this->loggedUser["id"]} limit 3;";
            $this->set("ptoControle", $this->projetos_projeto->fetch($sqlPtoControle));
            
            $sqlProximasAtividades = "select at.nome, at.inicio, pr.nome as projeto from projetos_atividades as at inner join projetos_projeto as pr where at.ativo=1 and at.responsavel ={$this->loggedUser["id"]} order by inicio ASC limit 7;";
            $this->set("qtdAtividades", $this->projetos_projeto->fetch($sqlProximasAtividades));
        }
        
        public function novo($id = null)
        {
            if(!empty($this->data))
            {
                $this->data["id"]=$id;
                $this->data['inicio'] = implode("-", array_reverse(explode("-",$this->data['inicio'])));

                $this->data['termino'] = implode("-", array_reverse(explode("-",$this->data['termino'])));

                if($this->projetos_projeto->save($this->data)){
                    $id = (!empty($id))?$id:$this->projetos_projeto->getInsertId();
                    $this->redirect("/projetos/gerencia/$id");
                }

            }

            $this->set("dadosForm",$this->projetos_projeto->firstById($id));

            $this->set("dadosResponsavel",
                    $this->rh_funcionarios->toList(
                            array("conditions"=>array
                                ("dt_desligamento"=>"0000-00-00"),
                                "displayField"=>"nome","order"=>"nome")));

            $this->set("dadosCliente",  $this->comercial_clientes->toList(
                    array(
                    "displayField"=>"razaoSocial","order"=>"razaoSocial")));
        }

        public function grid()
        {
            $where = array(
                "conditions"=>array(
                    //"responsavel"=>$this->AuthComponent->user("id")
                )
            );

            $this->set("dadosGrid", $this->projetos_projeto->all($where));
        }

        public function excluir($id)
        {
            $this->projetos_projeto->delete($id);

            $this->redirect("/projetos/grid");
        }

        public function atividades($op="grid",$projeto = null,$milestone = null,$id=null)
        {
            $this->set("op",$op);
            switch ($op) {
                case "novo":
                    if(!empty($this->data))
                    {
                        $this->data["id"]=$id;
                        
                        $this->data["projetos_projeto_id"]=$projeto;
                        
                        $this->data["projetos_milestones_id"]=$milestone;

                        $this->data['inicio'] = implode("-", array_reverse(explode("-",$this->data['inicio'])));

                        $this->data['termino'] = implode("-", array_reverse(explode("-",$this->data['termino'])));
                        
                        //Insere a atividade na agenda 
                        $dados["funcionario_id"] = $this->data["responsavel"]; 
                        $dados["titulo"] = "Lembrete: ".$this->data["nome"]; 
                        $dados["inicio"] = $this->data['inicio'] . " 08:00:00"; 
                        $dados["termino"] = $this->data['inicio'] . " 08:30:00"; 
                        $dados["observacao"] = "Lembrete Compromisso:".$this->data["descricao"]; 
                        $this->agenda_compromissos->save($dados); 
                        $this->data["agenda_compromissos_id"] = $this->agenda_compromissos->getInsertId(); 
                        ////termina

                        if($this->projetos_atividades->save($this->data)){
                            $this->redirect("/projetos/gerencia/$projeto");
                         }

                   }

                   $this->set("dadosResponsavel",
                    $this->rh_funcionarios->toList(
                            array("conditions"=>array
                                ("dt_desligamento"=>"0000-00-00"),
                                "displayField"=>"nome","order"=>"nome")));

                   $this->set("dadosSetores", $this->rh_setor->toList(
                           array("order"=>"nome","displayField"=>"nome")));

                   $this->set("nomeMilestones",$this->projetos_milestones->toList(
                           array(
                               "conditions"=>array(
                                   "projetos_projeto_id"=>$projeto
                               ),
                               "order"=>"nome",
                               "displayField"=>"nome"
                           )));

                   $this->set("dadosProjetos",$this->projetos_projeto->toList(
                           array(
                               "conditions"=>array(
                                   "projetos_projeto_id"=>"$id"
                                   ),
                               "order"=>"nome",
                               "displayField"=>"nome"
                               )));

                break;

                case "grid":
                    $this->set("dadosGrid",$this->projetos_atividades->all());
                    break;

                case "deletar":
                    $this->projetos_atividades->delete($id);
                    $this->redirect("/projetos/atividades/grid");
                    break;
            }
        }

        public function milestones($op = "novo",$projeto = null,$id=null)
        {
            $this->set("op",$op);
            switch ($op) {
                case "novo":
                    $this->layout = false;
                    if(!empty($this->data))
                    {
                        $this->data['id'] = $id;
                        $this->data["projetos_projeto_id"] = $projeto;
                        $this->data['previsao'] = implode("-", array_reverse(explode("-",$this->data['previsao'])));
                        if($this->projetos_milestones->save($this->data)){
                            $this->redirect("/projetos/gerencia/$projeto");
                        }
                    }
                    break;
                    
                    case "deletar":
                        $this->projetos_milestones->delete($id);
                        break;

            }
        }
        public function gerencia($id){
            if(empty ($id)){
               $this->redirect("/projetos/grid");
            }
            $this->set("dadosForm",$this->projetos_projeto->firstById($id));
        }
        
        
    }

?>
<?php

class MensageiroController extends AppController {
    public $uses = array(
        "sys_mensageiro", "SysMensageiroMensagens"
    );

    public function janelaConversa($conversa) {
        $this->layout = false;
        $this->set("conversa", $conversa);
    }

    public function gravarMensagem($conversa) {
        $this->layout = false;
        $dado = $this->sys_mensageiro->firstById($conversa);
        if (!empty($this->data)) {
            $this->data["sysmensageiro_id"] = $conversa;
            if($dado["requisitado"]==$this->AuthComponent->user("id")){
                $this->data["destinatario"]=$dado["requisitante"];
            }else{
                $this->data["destinatario"]=$dado["requisitado"];
            }
            $hoje = date("d/m/Y H:i");
            $this->data["msg"] = "[{$hoje}] - <b>" . $this->AuthComponent->user('nome') . " disse:</b>" . '<br/>' . $this->data["msg"] . "<br/>";
            $this->SysMensageiroMensagens->save($this->data);
            
        }
    }

    public function criaConversa($requisitado) {

        $condicao = array(            
            "conditions" => array(
                "requisitado" => array($requisitado, $this->AuthComponent->user("id")),
                "requisitante" => array($requisitado, $this->AuthComponent->user("id"))
            )
        );
        $conversaAnt = $this->sys_mensageiro->first($condicao);        
        if ($conversaAnt["id"] > 0) {
            $this->redirect("/mensageiro/janelaConversa/" . $conversaAnt["id"]);
        } else {

            $this->data["requisitado"] = $requisitado;
            $this->data["requisitante"] = $this->AuthComponent->user("id");
            $this->sys_mensageiro->save($this->data);
            $this->redirect("/mensageiro/janelaConversa/" . $this->sys_mensageiro->getInsertId());
        }
    }

    public function mensagensConversa($conversa) {
        $this->set("conversa", $conversa);
    }
}

?>
<?php

class MensageiroHelper extends Helper {

    public function listaOn($idUsr) {
        $lista = ClassRegistry::load("sys_online", "Model");
        $where = array(            
            "groupBy" => "id_user",
            "conditions"=>array(
                "id_user <>"=>$idUsr
            )
        );
        $retorno = $lista->all($where);
        return $retorno;
    }

    public function ApagaAntigos() {
        $lista = ClassRegistry::load("sys_online", "Model");
        $data = date("Y-m-d H:i:s", mktime(date('H'), date('i') - 1, date('s'), date('m'), date('d'), date('Y')));

        $where = "delete from sys_online where modified < '$data'";

        $lista->fetch($where);
    }

    public function incluiOnline($idUsr,$idEmpresa) {
        $lista = ClassRegistry::load("sys_online", "Model");
        $data = array(
            "id_user" => $idUsr,
            "sysEmpresas_id"=>$idEmpresa,
            "local" => $_SERVER["REQUEST_URI"]
        );
        $lista->save($data);
    }

    public function upDate($idUser,$empresa) {
        $this->ApagaAntigos();
        $this->incluiOnline($idUser,$empresa);
        return $this->listaOn($idUser);
    }

 public function mensagens($conversa) {
       $lista = ClassRegistry::load("SysMensageiroMensagens","Model");
       $data = array(
           "conditions"=>array(
               "sysmensageiro_id"=>$conversa
              ),
           "order"=>"id DESC"
       );
      return $lista->all($data);
    }

    public function verificaConversa($usr){
        $condicao = array(
          "conditions"  => array(
              "destinatario"=>$usr,
              "lido"=>"0"
          ),
            "groupBy"=>"sysmensageiro_id"
        );
        $lista = ClassRegistry::load("SysMensageiroMensagens","Model");

        $retorno = $lista->all($condicao);
        return $retorno;
    }

    public function setLido($idMsg){
        $dado["id"]=$idMsg;
        $dado["lido"]="1";
        $lista = ClassRegistry::load("SysMensageiroMensagens","Model");

        $retorno = $lista->save($dado);
    }

}

?>

<?php

class GeralHelper extends Helper {
    /*
     * @return Nome do Status
     */

    public function getStatusPadrao() {
        $model = ClassRegistry::load('status', 'Model');
        $padrao = $model->first(array("conditions" => array("padrao" => "1")));
        return $padrao["nome"];
    }

    public function getBeneficiario($id) {
        $model = ClassRegistry::load('rh_funcionarios', 'Model');
        $beneficiario = $model->first(array("conditions" => array("id" => $id)));
        return $beneficiario["nome"];
    }

    public function getPedidoReembolso($idUser, $status=array()) {
        $model = ClassRegistry::load('ocorrencia', 'Model');
        
        $condicao = array("conditions" => array(
                        "beneficiario" => $id,
                        "or" => array(
                            "status_id" => $status
                        )
                    )
                );
        
        if(array_keys($status, "0")){
            unset($condicao["conditions"]["beneficiario"]);
            $condicao["conditions"]["gerente"]=$id;
        }
        
        $quantidade = $model->count($condicao);
        
        return $quantidade;
    }

    public function getSolicitacaoAndamento($id) {
        $model = ClassRegistry::load('eticket_pedidos', 'Model');
        $quantidade = $model->count(array("conditions" => array(
                        "users_id" => $id,
                        "or" => array(
                            "status_id" => array(0, 1, 2)
                        )
                    )
                ));
        return $quantidade;
    }
    
    public function updatePrimeiroAcesso($idFuncionario){
        $model = ClassRegistry::load('rh_funcionarios', 'Model');
        $data["id"] = $idFuncionario;
        $data["primeiroAcesso"] = "1";
        $model->save($data);
    }

    /*
     * @param Recebe o Id do gerente que verificará pendencia de aprovação
     * @return Integer
     */

    public function getSolicitacaoAprovar($id) {
        $model = ClassRegistry::load("ocorrencia", "Model");
        $retorno = $model->fetch("
select Count(*) from
  `financeiro_reembolsos` INNER JOIN
  `rh_funcionarios` ON `financeiro_reembolsos`.`beneficiario` = `rh_funcionarios`.`id`
WHERE
   `rh_funcionarios`.`gerente_id` = $id
   AND `financeiro_reembolsos`.`status_id` = 0
");
        $retorno = $retorno[0]["Count(*)"];
        return $retorno;
    }

    public function statusRh($condicao=array()) {
        $model = ClassRegistry::load("rh_funcionarios");
        return $model->count($condicao);
    }

    public function statusFinanceiro($condicao=array()) {
        $model = ClassRegistry::load("ocorrencia");
        return $model->count($condicao);
    }

    public function statusFinanceiroValor($condicao=array()) {
        $model = ClassRegistry::load("ocorrencia");
        return $model->first($condicao);
    }

    public function getCompromissos($id) {
        $model = ClassRegistry::load("agenda_compromissos");
        $where = array(
            "conditions" => array(
                "termino >" => date("Y-m-d H:i"),
                "funcionario_id" => $id
            ),
            "fields" => array(
                "date_format(inicio,'%d/%m/%Y %H:%i') as inicio",
                "titulo"
            ),
            "order" => "inicio ASC",
            "limit" => "4"
        );
        return $model->all($where);
    }
    
    public function countPageViews($id){
        $model = ClassRegistry::load("site_paginas");
        $qtd = $model->firstById($id);
        $data["id"]=$id;
        $data["pageViews"] = $qtd["pageViews"]++;
        $model->save($data);
    }

    public function slice($length, $complement, $text) {
        if (strlen($text) > $length):
            $text = substr($text, 0, $length);
            $length = strrpos($text, " ");

            return substr($text, 0, $length) . $complement;
        else:
            return $text;
        endif;
    }

    public function custosReembolsoMes($motivoId) {
        $model = ClassRegistry::load("ocorrencia", "Model");
        $condicao = array(
            "conditions" => array(
                "motivodespesa_id" => $motivoId
            ),
            "groupBy" => "month(modified)",
            "fields" => "sum(valor) as valor, month(modified) as mes",
            "key" => "mes",
            "displayField" => "valor"
        );
        return $model->toList($condicao, false);
    }

    public function avisosUsuario($setor) {
        $where = array(
            "conditions" => array(
                "or" => array(
                    "rh_setor_id" => array("0", $setor)
                )
            ),
            "limit" => "5",
            "order" => "created DESC"
        );
        $model = ClassRegistry::load("admin_avisos", "Model");
        return $model->all($where);
    }

    public function getPhoto($url) {
        if (!file_exists(APP . DS . "webroot" . $url) || empty($url)) {
            $foto["url"] = "/nLayout/User1.png";
            $foto["bd"] = false;   
        } else {
            $foto["url"] = $url;
            $foto["bd"] = true;
        }
        return $foto;
    }

    public function criaSenha($tamanho=8) {
        $CaracteresAceitos = 'abcdef0123456789';
        $max = strlen($CaracteresAceitos) - 1;
        for ($i = 0; $i < $tamanho; $i++) {
            $retorno .= $CaracteresAceitos{mt_rand(0, $max)};
        }
        return $retorno;
    }
    
    public function getSaldoVV($cartao){     
    $url = "http://www.cbss.com.br/inst/convivencia/SaldoExtrato.jsp?numeroCartao=$cartao&primeiroAcesso=S";
    $cURL = curl_init($url);
            curl_setopt_array($cURL, array(CURLOPT_FOLLOWLOCATION => true,
                                           CURLOPT_RETURNTRANSFER => true
                              ));
           ! $res = curl_exec($cURL);
            $title = explode("<table class=\"consulta\" width=\"545\">",$res);
            $title = explode("<td class=\"corUm fontWeightDois\" style=\"width:80px\" align=\"right\">",$title[4]);
            $title = explode("</td></tr>",$title[1]);
            $saldo = $title[0];
           
                   
    curl_close($cURL);
     if(!empty($saldo)){
            return $saldo;
     }elseif(empty($saldo)){
         return "Cartão inválido";
     }
    }
    
    
        

    //APIs
     

/**
 * Esta função retorna uma data escrita da seguinte maneira:
 * Exemplo: Terça-feira, 17 de Abril de 2007
 * @author Leandro Vieira Pinho [http://leandro.w3invent.com.br]
 * @param string $strDate data a ser analizada; por exemplo: 2007-04-17 15:10:59
 * @return string
 */


    //talk
}

?>
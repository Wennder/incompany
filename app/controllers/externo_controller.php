<?php

class externoController extends AppController {

    public $uses = array(
        "agenda_compromissos",
        "financeiro_cobranca_boleto",
        "comercial_clientes"
    );

    public function cronEmail($op) {
        $this->layout = false;
        switch ($op) {
            //Rodará uma vez por dia somente.
            case "dia":
                $where = array(
                    "conditions" => array(
                        "inicio LIKE" => date("Y-m-d %")
                    ),
                    "order" => "inicio ASC"
                );
                $this->set("compromissos", $this->agenda_compromissos->all($where));
                break;
            case "hora":
                $diaHora = mktime(date("h") + 2, 0, 0, date("m"), date("d"), date("Y"));
                $diaHora = date("Y-m-d", $diaHora);
                $where = array(
                    "conditions" => array(
                        "inicio LIKE" => $diaHora . "%"
                    ),
                    "order" => "inicio ASC"
                );
                $this->set("compromissos", $this->agenda_compromissos->all($where));

                break;

            case "outro":

                break;
        }
    }

    public function verBoleto($id) {
        $this->layout = false;
        $this->set("boleto", $this->financeiro_cobranca_boleto->firstById($id));
    }

    public function consultaBoleto($op = "formConsulta") {
        $this->layout = "login";
        $this->set("op", $op);
        switch ($op) {
            case "gridConsulta":
                if (!empty($this->data)) {
                    $consultaCnpj = $this->comercial_clientes->first(array("conditions" => array("cnpj" => $this->data["cnpj"])));
                    $this->set("cnpj", $this->data["cnpj"]);
                    $this->set("dadosGrid", $this->financeiro_cobranca_boleto->all(array("conditions" => array("pago" => "0", "comercialCliente_id" => $consultaCnpj["id"]))));
                }
                break;
        }
    }

    public function confirmaLeituraEmail($id) {
        $this->layout = false;
        $this->EmailComponent->setReaded($id);
    }
    
    public function scheudule(){
        $this->EmailComponent->enviar();
        die();
    }

}

?>

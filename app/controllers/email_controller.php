<?php

class emailController extends AppController {

    public $uses = array(
        "email_mensagens",
        "email_destinatarios"
    );

    public function index($modulo) {
        $this->set("modulo", $modulo);
        $this->EmailComponent->
    }

    public function editor($modulo, $mensagem) {
        if (!empty($this->data)) {
            if ($this->EmailComponent->saveMessage($mensagem, $this->data)) {
                die("Salvo com Sucesso");
            } else {
                die("Ocorreu um erro durante sua requisição");
            };
        }
        $this->set("dadosForm", $this->EmailComponent->getMessage($modulo, $mensagem));
    }

    public function contacts($op, $mensagem) {
        $this->set("op", $op);
        $this->set("mensagem", $mensagem);
        switch ($op) {
            case "add":
                if (!empty($this->data)) {
                    if ($this->EmailComponent->addContact($mensagem, $this->data)) {
                        die("Inserido com Sucesso");
                    }else{
                        die("Ocorreu um erro durante a execução, tente novamente");
                    }
                }
                break;
            default:
            case "list":
                $this->set("dadosGrid", $this->EmailComponent->contactList($mensagem));
            break;
        case "deletar":
            $this->EmailComponent->delContact($mensagem);
            break;
        }
    }

}

?>

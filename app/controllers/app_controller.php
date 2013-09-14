<?php
//ini_set("display_errors",1);
class AppController extends Controller {

    public $components = array("Validation","Auth", "Upload", "Image", "Email", "Form", "Importacoes", "Nfe","Tracking");
    public $helpers = array("Importacoes", "Pagination", "Html", "Form", "Xgrid", "Geral", "Date", "Mensageiro", "Email", "Gadgets", "financeiro", "pdf", "phpjasper","webservices");
    public $uses = array("rh_setor");

    /**
     * Lista dos Estados da Federação Brasileira
     */
    public $optionEstados = array("0" => "Selecione...", "12" => "AC", "27" => "AL", "16" => "AP", "13" => "AM", "29" => "BA", "23" => "CE", "53" => "DF", "32" => "ES", "52" => "GO", "21" => "MA", "51" => "MT", "50" => "MS", "31" => "MG", "15" => "PA", "25" => "PB", "41" => "PR", "26" => "PE", "22" => "PI", "33" => "RJ", "24" => "RN", "43" => "RS", "11" => "RO", "14" => "RR", "42" => "SC", "35" => "SP", "28" => "SE", "17" => "TO", "99" => "EX");

    /**
     * Documentos que podem ser anexados
     */
    public $documentos = array("Selecione...", "Foto", "RG", "CPF", "C. Profissional", "Titulo de Eleitor", "N° Pis", "Outro");
    public $pagesAvaible = array();
    public $tiposBanner = array(
        "Selecione...",
        "Boleto",
        "Home Site"
    );
    public $loggedUser = array();

    public function beforeFilter() {
        $this->setupAuth();
        //pr($this->AuthComponent->pages);
        //Verifica se é uma requisição AJAX
        if ($this->isXhr()):
            $this->layout = false;
        endif;
        
        if($this->isMobile()){
            $this->layout = "mobile";
            $this->params["extension"] = "mobi";
        }

        //Grava as variáveis usadas no sistema inteiro
        $this->set("listaDoc", $this->documentos);

        $this->set("optionsEstados", $this->optionEstados);
        $this->set("bool", array("0" => "Não", "1" => "Sim"));
        //-----------------------------------------------------------
        $this->set("statusDespesa", array("Aguardando Posição", "Aprovada", "Negada", "Paga", "Não Paga", "Provisionada", "Cancelado"));
        $this->set("statusFinanceiro", array("1" => "Aprovada", "3" => "Paga", "4" => "Não Paga", "5" => "Provisionada"));
        $this->set("statusGerente", array("1" => "Aprovada", "2" => "Negada"));
        //-----------------------------------------------------------
        $this->set("unidadesMedida", array(
            "Selecione...",
            "Unidades",
            "Pares",
            "Kg",
            "Ton"
        ));
        //-----------------------------------------------------------
        //Grava a váriavel com a pasta Root do sistema,para ser usada no upload
        $this->set("pathSistema", APP . DS);
        //-----------------------------------------------------------
        $this->set("parentescos", array("Selecione...", "Pai", "Mãe", "Filho(a)", "Neto(a)", "Bisneto(a)", "Outro"));
        $this->set("perfisAcesso", array("Selecione...", "Admin", "RH", "Financeiro", "Técnico"));
        //-----------------------------------------------------------------
    }

    public function verificaGenrencia() {
        $setor = $this->rh_setor->first(array("conditions" => array("id" => $this->AuthComponent->user("rh_setor_id"))));
        $this->set('emailSetor', $setor["email"]);
        return (substr_count($setor["email"], $this->AuthComponent->user("username")) > 0) ? true : false;
    }

    public function isXhr() {
        return array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
    
    public function isMobile(){
        $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
        $isiPod = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPod');
        $isiPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
        $isAndroid = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
        if($isiPad || $isiPhone || $isAndroid || $isiPod){
            return true;
        }else{
            return false;
        }
        
    }

    private function setupAuth() {
        $this->AuthComponent->userModel = "rh_funcionarios";
        $this->AuthComponent->hash = "sha1";
        $this->AuthComponent->loginAction = "/site";
        $this->AuthComponent->logoutAction = "/site/logout";
        $this->AuthComponent->deny("(:any)");
        $this->set("loggedUser", $this->AuthComponent->user());
        $this->loggedUser = $this->AuthComponent->user();
        //Trecho que aplica permissao
        $permissaoUser = $this->AuthComponent->user();
        $permissaoUser = explode(",", $permissaoUser["rh_setor"]["sys_permissoes"]["paginas"]);
        $this->pagesAvaible = $permissaoUser;
        $this->set("pagesAvaible", $this->pagesAvaible);
        //pr($this->AuthComponent->permissions);
        if (!$this->AuthComponent->loggedIn) {
            $this->AuthComponent->allow("/site/cadastrarSenha");
            $this->AuthComponent->allow("/site/(:any)");
            $this->AuthComponent->allow("/externo(:any)");
        } else {
            $this->AuthComponent->allow("/home");
            $this->AuthComponent->allow("/mensageiro(:any)");
            foreach ($permissaoUser as $pagina) {
                $allow = $this->AuthComponent->permissions[$pagina];
                $this->AuthComponent->allow($allow[1]);
                unset($allow);
            }
        }
    }

}

?>
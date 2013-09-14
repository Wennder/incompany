<?php

/**
 * AuthComponent � o respons�vel pela autentica��o e controle de acesso na aplica��o.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright 2008-2009, Spaghetti* Framework (http://spaghettiphp.org/)
 *
 */
class AuthComponent extends Component {

    /**
     * Autoriza��o para URLs n�o especificadas explicitamente.
     */
    public $authorized = true;
    /**
     * Define se AuthComponent::check() ser� chamado automaticamente.
     */
    public $autoCheck = true;
    /**
     * Inst�ncia do controller.
     */
    public $controller;
    /**
     * Nomes dos campos do modelo a serem usados na autentica��o.
     */
    public $fields = array(
        "id" => "id",
        "username" => "username",
        "password" => "password"
    );
    /**
     * M�todo de hash a ser usado para senhas.
     */
    public $hash = "sha1";
    /**
     * Estado de autentica��o do usu�rio corrente.
     */
    public $loggedIn;
    /**
     * Action que far� login.
     */
    public $loginAction = "/site/";
    
    public $accessDanied = "/home/accessDanied";
    /**
     * URL para redirecionamento ap�s o login.
     */
    public $loginRedirect = "/home";
    /**
     * Action que far� logout.
     */
    public $logoutAction = "/site/logout";
    /**
     * URL para redirecionamento ap�s o logout.
     */
    public $logoutRedirect = "/site/";
    /**
     * Lista de páginas do Site
     */
    public $pages = array( 
    );
    /**
     * Lista de permissões.
     * Funcionamento
     * Primeiro Dígito: Sistema (1 = SCR, 2=SGO, 3=SITE)
     * Segundo e Terceiro Dígito (01, 02..., 99) Módulo do Sistema
     * Terceiro Dígito: (0, 1, 2...9) Permissão especial/ Somente leitura...
     */
    public $permissions = array(
        "1000"=>array("TOTAL","(:any)"),//Permissão Total
        "1010"=>array("HOME","/home(:any)"), //Permissão Módulo Home
        "1020"=>array("RH TOTAL","/rh(:any)"), //RH Completo
        "1021"=>array("RH Ficha Funcionario","/rh/fichaFuncionario(:any)"), //RH, Permissão Especial ver Ficha do Colaborador
        "1030"=>array("COMERCIAL","/comercial(:any)"), //Módulo Financeiro Completo
        "1040"=>array("FINANCEIRO","/financeiro(:any)"),//Módulo financeiro Completo
        "1050"=>array("SOLICITAÇÕES","/solicitacoes(:any)"),//Módulo de Solicitações Completo
        "1060" =>array("ETICKET","/eticket(:any)"), //Módulo Completo eticket
        "1070" =>array("ADMIN","/admin(:any)"),//Módulo Admin
        "1080"=>array("AGENDA","/agenda(:any)"),//Módulo Agenda
        "1090"=>array("SITE","/site(:any)"),//Site
        "1100"=>array("ADM SITE","/admsite(:any)"),//Módulo Administraçao do Site
        "1110"=>array("PROJETOS","/projetos(:any)"), // Módulo de projetos
        "1120"=>array("FERRAMENTAS","/ferramentas(:any)"), // Módulo de Ferramentas
        "1121"=>array("TOTAL","/ferramentas(:any)") // URL repetida, porem se trata da permissão de Intervenção Fiscal
    );
    /**
     * Usuario atual.
     */
    public $user = array();
    /**
     * Nome do modelo a ser utilizado para a autenticação.
     */
    public $userModel = "rh_funcionarios";
    /**
     * Condições adicionais para serem usadas na autenticação.
     */
    public $userScope = array(
        "dt_admissao <>" => "0000-00-00",
        "dt_desligamento" => "0000-00-00"
    );
    /**
     * Define se o salt ser� usado como prefixo das senhas.
     */
    public $useSalt = true;
    /**
     * Data de expira��o do cookie.
     */
    public $expires;
    /**
     * Caminho para o qual o cookie est� dispon�vel.
     */
    public $path = "/";
    /**
     * Dom�nio para ao qual o cookie est� dispon�vel.
     */
    public $domain = "";
    /**
     * Define um cookie seguro.
     */
    public $secure = false;
    /**
     * Define o n�vel de recurs�o do modelo.
     */
    public $recursion;
    /**
     * Mensagem de erro para falha no login.
     */
    public $loginError = "Usuário/Senha inválidos";
    /**
     * Mensagem de erro para acesso n�o autorizado.
     */
    public $authError = "Página Restrita, logue-se para ter acesso";
    /**
     * Define a mensagem a ser exibida quando logado, mas não autorizado
     */
    public $errorPermission = "Você não tem permissão para acessar a página requisitada.";
    public $authenticate = false;

    /**
     * Inicializa o componente.
     *
     * @param object $controller Objeto Controller
     * @return void
     */
    public function initialize(&$controller) {
        $this->controller = $controller;
    }

    /**
     * Faz as opera��es necess�rias ap�s a inicializa��o do componente.
     *
     * @param object $controller Objeto Controller
     * @return void
     */
    public function startup(&$controller) {
        $this->allow($this->loginAction);
        if ($this->autoCheck):
            $this->check();
        endif;
        if (Mapper::match($this->loginAction)):
            $this->login();
        endif;
    }

    /**
     * Finaliza o component.
     *
     * @param object $controller Objeto Controller
     * @return void
     */
    public function shutdown(&$controller) {
        if (Mapper::match($this->loginAction)):
            $this->loginRedirect();
        endif;
    }

    /**
     * Verifica se o usu�rio est� autorizado a acessar a URL atual, tomando as
     * a��es necess�rias no caso contr�rio.
     *
     * @return boolean Verdadeiro caso o usu�rio esteja autorizado
     */
    public function check() {
//        if (!$this->loggedIn()){
//            $this->setAction(Mapper::here());
//            $this->error($this->authError);
//            $this->controller->redirect($this->loginAction);
//            return false;
//        }elseif($this->loggedIn() && !$this->authorized()){
//            $this->setAction(Mapper::here());
//            $this->error($this->errorPermission);
//            $this->controller->redirect($this->loginRedirect);
//            return false;
//        }
//        return true;
        if (!$this->authorized()):
            $this->setAction(Mapper::here());

            if (!$this->loggedIn()) {
                $message = $this->authError;
                $url = $this->loginAction;
            } else {
                $message = $this->errorPermission;
                $url = $this->accessDanied;
            }
            $this->error($message);
            $this->controller->redirect($url);
            return false;
        endif;
        return true;
    }

    /**
     * Verifica se o usu�rio esta autorizado ou n�o para acessar a URL atual.
     *
     * @return boolean Verdadeiro caso o usu�rio esteja autorizado
     */
    public function authorized() {
        return $this->isPublic();
    }

    /**
     * Verifica se uma action � p�blica.
     *
     * @return boolean Verdadeiro se a action � p�blica
     */
    public function isPublic() {
        $here = Mapper::here();
        $authorized = $this->authorized;
        foreach ($this->pages as $url => $permission):
            if (Mapper::match($url, $here)):
                $authorized = $permission;
            endif;
        endforeach;
        return $authorized;
    }

    /**
     * Libera URLs a serem visualizadas sem autentica��o.
     *
     * @param string $url URL a ser liberada
     * @return void
     */
    public function allow($url = null) {
        if (is_null($url)):
            $this->authorized = true;
        else:
            $this->pages[$url] = true;
        endif;
    }

    /**
     * Bloqueia os URLS para serem visualizadas apenas com autentica��o.
     *
     * @param string $url URL a ser bloqueada
     * @return void
     */
    public function deny($url = null) {
        if (is_null($url)):
            $this->authorized = false;
        else:
            $this->pages[$url] = false;
        endif;
    }

    /**
     * Verifica se o usu�rio est� autenticado.
     *
     * @return boolean Verdadeiro caso o usu�rio esteja autenticado
     */
    public function loggedIn() {
        if (is_null($this->loggedIn)):
            $user = Cookie::read("user_id");
            $password = Cookie::read("password");
            if (!is_null($user) && !is_null($password)):
                $user = $this->identify(array(
                            $this->fields["id"] => $user,
                            $this->fields["password"] => $password
                        ));
                $this->loggedIn = !empty($user);
            else:
                $this->loggedIn = false;
            endif;
        endif;
        return $this->loggedIn;
    }

    /**
     * Identifica o usu�rio no banco de dados.
     *
     * @param array $conditions Condi��es da busca
     * @return array Dados do usu�rio
     */
    public function identify($conditions) {
        $userModel = ClassRegistry::load($this->userModel);
        if (!$userModel):
            $this->setAlert("missingModel". $this->userModel);
            return false;
        endif;
        $params = array(
            "conditions" => array_merge(
                    $this->userScope, $conditions
            ),
            "recursion" => is_null($this->recursion) ? $userModel->recursion : $this->recursion
        );
        return $this->user = $userModel->first($params);
    }

    /**
     * Cria o hash de uma senha.
     *
     * @param string $password Senha para ter o hash gerado
     * @return string Hash da senha
     */
    public function hash($password) {
        return Security::hash($password, $this->hash, $this->useSalt);
    }

    /**
     * Efetua o login do usu�rio.
     *
     * @return void
     */
    public function login() {
        if (!empty($this->controller->data)):
            $password = $this->hash($this->controller->data[$this->fields["password"]]);
            $user = $this->identify(array(
                        $this->fields["username"] => $this->controller->data[$this->fields["username"]],
                        $this->fields["password"] => $password
                    ));
            if (!empty($user)):
                $this->authenticate = true;
            else:
                $this->error($this->loginError);
            endif;
        endif;
    }

    public function loginRedirect() {
        if ($this->authenticate):
            $this->authenticate($this->user[$this->fields["id"]], $this->user[$this->fields["password"]]);
            if ($redirect = $this->getAction()):
                $this->loginRedirect = $redirect;
            endif;
            $this->controller->redirect($this->loginRedirect);
        endif;
    }

    /**
     * Autentica um usu�rio.
     *
     * @param string $id ID do usuário
     * @param string $password Senha do usu�rio
     * @return void
     */
    public function authenticate($id, $password) {
        Cookie::set("domain", $this->domain);
        Cookie::set("path", $this->path);
        Cookie::set("secure", $this->secure);
        Cookie::write("user_id", $id, $this->expires);
        Cookie::write("password", $password, $this->expires);
    }

    /**
     * Efetua o logout do usu�rio.
     *
     * @return void
     */
    public function logout() {
        Cookie::set("domain", $this->domain);
        Cookie::set("path", $this->path);
        Cookie::set("secure", $this->secure);
        Cookie::delete("user_id");
        Cookie::delete("password");
        $this->controller->redirect($this->logoutRedirect);
    }

    /**
     * Retorna informa��es do usu�rio.
     *
     * @param string $field Campo a ser retornado
     * @return mixed Campo escolhido ou todas as informa��es do usu�rio
     */
    public function user($field = null) {
        if ($this->loggedIn()):
            if (is_null($field)):
                return $this->user;
            else:
                return $this->user[$field];
            endif;
        else:
            return null;
        endif;
    }

    /**
     * Armazena a action requisitada quando a autoriza��o falhou.
     *
     * @param string $action Endere�o da action
     * @return void
     */
    public function setAction($action) {
        Session::write("Auth.action", $action);
    }

    /**
     * Retorna a action requisitada quando a autoriza��o falhou.
     *
     * @return string Endere�o da action
     */
    public function getAction() {
        $action = Session::read("Auth.action");
        Session::delete("Auth.action");
        return $action;
    }

    /**
     * Define um erro ocorrido durante a autentica��o.
     *
     * @param string $type Nome do erro
     * @param array $details Detalhes do erro
     * @return void
     */
    public function error($type, $details = array()) {
        Session::writeFlash("Auth.error", $type);
    }

    public function createPassword() {
        $CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
        $max = strlen($CaracteresAceitos) - 1;
        for ($i = 0; $i < 8; $i++) {
            $retorno .= $CaracteresAceitos{mt_rand(0, $max)};
        }
        return $retorno;
    }

}

?>
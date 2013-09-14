<?php

class estoqueController extends AppController {

    public $uses = array(
        "estoque_fornecedores",
        "estoque_transportadoras",
        "estoque_produtos",
        "estoque_catprodutos",
        "sys_moedas"
    );

    public function index() {
        
    }

    public function fornecedores($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "fields" => array(
                        "id", "nomeFantasia", "cidade", "pais"
                    ),
                    "limit" => "10",
                    "order" => "nomeFantasia ASC"
                );
                if (!empty($this->data)) {
                    $condicao["conditions"]["nomeFantasia LIKE"] = "%" . $this->data["nomeFantasia"] . "%";
                    $condicao["limit"] = $this->data["limit"];
                }
                $this->set("dadosGrid", $this->estoque_fornecedores->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->estoque_fornecedores->save($this->data);
                    $idSalvo = $this->estoque_fornecedores->getInsertId();
                    $this->redirect("/estoque/fornecedores/cadastrar/". (!empty($idSalvo) ? $idSalvo : $id));
                    }
                $this->set("dadosFormulario", $this->estoque_fornecedores->firstById($id));
                break;

            case "deletar":
                $this->estoque_fornecedores->delete($id);
                break;
        }
    }

    public function catProdutos($op, $pai = 0, $id = null) {
        $this->set("op", $op);
        $this->set("pai", $pai);
        $this->set("id", $id);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "pai" => $pai
                    ),
                    "recursion" => -1,
                    "order" => "nome"
                );
                $this->set("dadosGrid", $this->estoque_catprodutos->all($condicao));
                break;
            case "form":
                if (!empty($this->data)) {
                    $this->data["pai"] = $pai;
                    $this->data["id"] = $id;
                    if (!$this->estoque_catprodutos->save($this->data)) {
                        $this->setAlert("Ocorreu Algum Erro Durante sua Requisição");
                    }
                }
                $this->set("dadosForm", $this->estoque_catprodutos->firstById($id));
                break;
            case "deletar":
                $this->estoque_catprodutos->delete($pai, true);
                break;

            case "ajaxOptions":
                $this->set("selecao", $id);
                $condicao = array(
                    "conditions" => array(
                        "pai" => $pai
                    ),
                    "displayField" => "nome",
                    "order" => "nome"
                );
                $this->set("dadosForm", $this->estoque_catprodutos->toList($condicao));
                break;
        }
    }

    public function produtos($op = "grid", $id = null) {
        $this->set("op", $op);
        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "fields" => array(
                        "id", "pNumber", "moedas_id", "descricao", "qtdAtual", "preco", "precoExterior", "fabricantes_id"
                    ),
                    "limit" => "10",
                    "order" => "descricao"
                );
                //Verifica se foi enviado algo pelo formulário de Busca
                if (!empty($this->data)) {
                    if (!empty($this->data["ean"])) {
                        $condicao["conditions"] = array("ean" => $this->data["ean"]);
                    } else {
                        $condicao["conditions"] = array("or" => array("descricao LIKE" => "%" . $this->data["descricao"] . "%", "pNumber LIKE" => "%" . $this->data["descricao"] . "%"));
                    }
                    if (!empty($this->data["categoria1"]) && $this->data["categoria1"] > 0) {
                        $condicao["conditions"]["grupoProduto"] = $this->data["categoria1"];
                    }
                    if (!empty($this->data["categoria2"]) && $this->data["categoria2"] > 0) {
                        $condicao["conditions"]["tipoProduto"] = $this->data["categoria2"];
                    }
                    if (!empty($this->data["categoria3"]) && $this->data["categoria3"] > 0) {
                        $condicao["conditions"]["segmentoProduto"] = $this->data["categoria3"];
                    }
                    if (!empty($this->data["categoria4"]) && $this->data["categoria4"] > 0) {
                        $condicao["conditions"]["processoProduto"] = $this->data["categoria4"];
                    }
                    $condicao["limit"] = $this->data["limit"];
                }

                $this->set("dadosGrid", $this->estoque_produtos->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data['id'] = $id;
                    //$this->estoque_produtos->fetch("insert into estoque_produtos (pNumber) values('123Comer');");
                    if (!$this->estoque_produtos->save($this->data)) {
                        print("Ocorreu um erro ao gravar o registro no BD");
                    }else{
                        $idSalvo = $this->estoque_produtos->getInsertId();
                        $this->redirect("/estoque/produtos/cadastrar/".(!empty($idSalvo)?$idSalvo:$id));
                    }
                }
                    $this->set("listMoedas", $this->sys_moedas->toList(array("displayField" => "nome", "order" => "nome ASC")));
                    $this->set("listFornecedores", $this->estoque_fornecedores->toList(array("displayField" => "nomeFantasia", "order" => "nomeFantasia ASC")));
                    $this->set("dadosForm", $this->estoque_produtos->firstById($id));
                
                break;

            case "byCategory":
                $condicao = array(
                    "fields" => array(
                        "id", "pNumber", "moedas_id", "descricao", "qtdAtual", "preco", "precoExterior", "fabricantes_id"
                    ),
                    "limit" => "10",
                    "order" => "descricao"
                );
                $condicao["conditions"] = array(
                    "or" => array(
                        "grupoProduto" => $id,
                        "tipoProduto" => $id,
                        "processoProduto" => $id,
                        "segmentoProduto" => $id
                        ));

                $this->set("dadosGrid", $this->estoque_produtos->all($condicao));
                $this->set("op", "grid");
                break;

            case "deletar":
                $this->estoque_produtos->delete($id);
                $this->redirect("/estoque/produtos");
                break;
            case "buscar":
                $condicao = array(
                    "conditions" => array(
                        "pai" => "0"
                    ),
                    "displayField" => "nome",
                    "order" => "nome"
                );
                $this->set("dadosCat1", $this->estoque_catprodutos->toList($condicao));
                break;

            case "ajax":

                break;
        }
    }

    public function transportadoras($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "fields" => array(
                        "id", "razaoSocial", "cidade","estado_id", "pais"
                    ),
                    "limit" => "20",
                    "order" => "id DESC"
                );
                $this->set("dadosGrid", $this->estoque_transportadoras->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    foreach ($this->data["tipoTransporte"] as $viaTransporte) {
                        $this->data["tipotransporte"] .= ",$viaTransporte";
                    }
                    $this->estoque_transportadoras->save($this->data);
                    $this->redirect("/estoque/");
                }
                $this->set("dadosFormulario", $this->estoque_transportadoras->firstById($id));
                break;

            case "deletar":
                $this->estoque_transportadoras->delete($id);
                $this->redirect("/estoque/");
                break;
        }
    }

}

?>

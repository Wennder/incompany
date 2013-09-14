<?php

class integracaoController extends AppController {

    public $uses = array(
        "comercial_clientes",
        "comercial_contatos",
        "estoque_produtos",
        "estoque_catprodutos",
        "estoque_fornecedores",
        "estoque_transportadoras",
        "importacoes_agentescarga",
        "importacoes_nomecustos",
        "sys_ncm",
        "sys_cfop",
        "sys_municipios"
    );

    public function autocomplete($model, $campo) {
        $search = $_GET["term"];
        $condicao = array(
            "fields" => array("id", $campo . " as nome"),
            "conditions" => array(
                $campo . " LIKE" => "%" . $search . "%"
            ),
            "limit" => "5"
        );

        $this->set("return", $this->$model->all($condicao));
    }

    public function autocompleteCfop() {
        $search = $_GET["term"];
        //$this->view("autoComplete");
        $condicao = array(
            "conditions" => array(
                "cfop LIKE" => "%" . $search . "%"
            )
        );

        $this->set("return", $this->sys_cfop->all($condicao));
    }

    public function autocompleteProduto() {
        $search = $_GET["term"];
        $condicao = array(
            "conditions" => array(
                "or" => array(
                    "pNumber LIKE" => "%" . $search . "%",
                    "descricao LIKE" => "%" . $search . "%",
                )
            ),
            "orderBy" => "descricao ASC",
            "limit" => "5"
        );

        $this->set("return", $this->estoque_produtos->all($condicao));
    }

    public function options($model, $displayField, $value, $campoCondicao = null, $termoCondicao = null) {

        $condicao = array(
            "displayField" => $displayField,
            "order" => $displayField . " ASC",
        );

        if ($campoCondicao != null && $termoCondicao != null) {
            $condicao["conditions"] = array(
                $campoCondicao => $termoCondicao
            );

            $this->set("options", $this->$model->toList($condicao));
            $this->set("selecionado", $value);
        }
    }

    public function verificaNcm($ncm) {
        $condicao = array(
            "conditions" => array(
                "ncm" => $ncm
            )
        );
        $this->set("contagem", $this->sys_ncm->count($condicao));
    }

    public function agenteCarga($value) {

        $condicao = array(
            "displayField" => "nomeFantasia",
            "order" => "nomeFantasia ASC",
        );

        $this->set("options", $this->importacoes_agentescarga->toList($condicao));
        $this->set("selecionado", $value);
    }

    public function cep($cep) {
        $this->set("cep", $cep);
    }

}

?>

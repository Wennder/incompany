<?php

class relatoriosController extends AppController {

    public $uses = array(
        "comercial_clientes",
        "comercial_clientesconsumo",
        "estoque_catprodutos",
        "importacoes_processos",
        "importacoes_fabricantesprocesso",
        "importacoes_custosfechamento",
        "importacoes_nacionalizacao",
        "importacoes_produtos"
    );
    public $layout = false;

    public function importacoes_fechamento($processo) {
        $condicao = array(
            "conditions" => array(
                "processo" => $processo
            ),
            "order" => "credito DESC, data ASC"
        );

        $this->set("custos", $this->importacoes_custosfechamento->all($condicao));
        $condicao["order"] = null;
        $this->set("processo", $this->importacoes_processos->first($condicao));
        $this->set("exportadores", $this->importacoes_fabricantesprocesso->all($condicao));
    }

    public function importacoes_planilha($processo) {
        $condicao = array(
            "conditions" => array(
                "processo" => $processo
            )
        );
        $this->set("processo", $this->importacoes_processos->first($condicao));
        $this->set("despesasNacionalizacao", $this->importacoes_nacionalizacao->all($condicao));

        $condicao["groupBy"] = "ncm";
        $condicao["fields"] = array("ncm");

        $this->set("adicoes", $this->importacoes_produtos->all($condicao));
    }

    public function importacoes_precovenda($op = "filtro", $processo) {
        $this->set("filtro", $this->data);
        $this->set("op", $op);
        $this->set("idProcesso", $processo);
        switch ($op) {
            default:
            case "imprimir":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    )
                );
                $this->set("processo", $this->importacoes_processos->first($condicao));
                $condicao["order"] = "ncm";
                $this->set("itens", $this->importacoes_produtos->all($condicao));
                break;
        }
    }

    public function comercial_mercado($op = "filtro") {
        $this->set("op", $op);
        switch ($op) {
            default:
            case "filtro":
                $condicao = array(
                    "conditions" => array(
                        "pai" => "0"
                    ),
                    "displayField" => "nome",
                    "order" => "nome"
                );
                $this->set("dadosCat1", $this->estoque_catprodutos->toList($condicao));
                break;

            case "imprimir":
                //ini_set("display_errors",1);
                $this->set("filtro", $this->data);
                //Seleciona os consumos
                $this->set("dadosRelatorio", $this->comercial_clientesconsumo->relatorioMercadoImportacao($this->data));
                $this->set("estoqueCategorias",$this->estoque_catprodutos->toList(array("displayField"=>"nome")));
                break;
        }
    }

    public function comercial_fichaCliente($op) {
        $this->set("op", $op);

        switch ($op) {
            default:
            case "filtro":
                $condicao = array(
                    "conditions" => array(
                        "pai" => "0"
                    ),
                    "displayField" => "nome",
                    "order" => "nome"
                );
                $this->set("dadosCat1", $this->estoque_catprodutos->toList($condicao));
                break;

            case "imprimir":
                $this->set("filtro", $this->data);
                $fields = array(
                    "razaoSocial",
                    "nomeFantasia",
                    "fone",
                    "cnpj",
                    "created",
                    "id",
                    "municipio_id",
                    "estado_id"
                );
                $this->set("estoqueCategorias",$this->estoque_catprodutos->toList(array("displayField"=>"nome")));
                $this->set("dadosRelatorio", $this->comercial_clientes->findForm($this->data,$fields));
                break;
        }
    }

}

?>

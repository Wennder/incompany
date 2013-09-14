<?php

class comercial_clientesconsumo extends AppModel {

    public $table = "comercial_clientesConsumo";
    public $hasOne = array(
        "grupo" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria1"
        ),
        "tipo" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria2"
        ),
        "aplicacao" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria3"
        ),
        "final" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria4"
        )
    );

    public function relatorioMercadoImportacao($filtro) {
        $query = "select consumo.estoqueCategoria1, categoria1.nome as cat1Nome, consumo.estoqueCategoria2, categoria2.nome as cat2Nome, consumo.estoqueCategoria3, consumo.estoqueCategoria4, consumo.qtdConsumo,consumo.unConsumo,consumo.modified, consumo.concorrente, consumo.modeloLocal, consumo.precoLocal, cliente.nomeFantasia, cliente.classificacao from comercial_clientesConsumo as consumo right join comercial_clientes cliente on cliente.id = consumo.cliente_id inner join estoque_categoriaProdutos categoria1 on consumo.estoqueCategoria1 = categoria1.id inner join estoque_categoriaProdutos categoria2 on consumo.estoqueCategoria2 = categoria2.id";
        if (($filtro["estado"] > 0) || ($filtro["categoria1"] > 0)) {
            $query .= " where";
        }
        if ($filtro["categoria1"] > 0) {
            $query .= " consumo.estoqueCategoria1 = {$filtro["categoria1"]}";
            if ($filtro["categoria2"] > 0) {
                $query .= " and consumo.estoqueCategoria2 = {$filtro["categoria2"]}";
                if ($filtro["categoria3"] > 0) {
                    $query .= " and consumo.estoqueCategoria3 = {$filtro["categoria3"]}";
                    if ($filtro["categoria4"] > 0) {
                        $query .= " and consumo.estoqueCategoria4 = {$filtro["categoria4"]}";
                    }
                }
            }
        }
        //Coloca o AND caso necessite
        if (($filtro["estado"] > 0) && ($filtro["categoria1"] > 0)) {
            $query .= " and";
        }

        if ($filtro["estado"] > 0) {
            $query .= " cliente.estado_id={$filtro["estado"]}";
        }

        if ($filtro["classificacao"] >= 0) {
            $query .= " and cliente.classificacao = {$filtro["classificacao"]}";
        }

        $query .= " order by consumo.estoqueCategoria1,consumo.estoqueCategoria2, cliente.nomeFantasia";
        //die($query);
        return $this->fetch($query);
    }

    public function updatePrice($data) {

        if ($data["estoqueCategoria1"] > 0) {
            $condicaoConsumo["conditions"]["estoqueCategoria1"] = $data["estoqueCategoria1"];
            if ($data["estoqueCategoria2"] > 0) {
                $condicaoConsumo["conditions"]["estoqueCategoria2"] = $data["estoqueCategoria2"];
                if ($data["estoqueCategoria3"] > 0) {
                    $condicaoConsumo["conditions"]["estoqueCategoria3"] = $data["estoqueCategoria3"];
                    if ($data["estoqueCategoria4"] > 0) {
                        $condicaoConsumo["conditions"]["estoqueCategoria4"] = $data["estoqueCategoria4"];
                    }
                }
            }
            if (empty($data["ignorarData"])) {
                $condicaoConsumo["conditions"]["modified <="] = "str_to_date(".$data["data"].", %d-%m-%Y)";
            }
            
            $toUpdate = $this->all($condicaoConsumo);
            foreach ($toUpdate as $registro) {
                $dados[] = array(
                    "id" => $registro["id"],
                    "precoLocal" => $data["preco"],
                );
            }
        }
        return $this->saveAll($dados);
    }

}

?>

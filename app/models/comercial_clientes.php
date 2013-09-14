<?php

class comercial_clientes extends AppModel {

    public $hasMany = array(
        "contatos" => array(
            "className" => "comercial_contatos",
            "primaryKey" => "id",
            "foreignKey" => "id_cliente",
            "conditions"=>array(
                "id_modulo"=>"2"
            )
            ),
        "contratos" => array(
            "className" => "comercial_contratos",
            "primaryKey" => "id",
            "foreignKey" => "id_cliente"
            ),
        "consumo" => array(
            "className" => "comercial_clientesconsumo",
            "primaryKey" => "id",
            "foreignKey" => "cliente_id"
            ),
        "enderecos" => array(
            "className" => "comercial_clientesenderecos",
            "primaryKey" => "id",
            "foreignKey" => "cliente_id"
            )
    );
    public $hasOne = array(
        "representante" => array("className" => "comercial_representantes", "primaryKey" => "id", "foreignKey" => "representante_id"),
        "municipio" => array("className" => "sys_municipios", "primaryKey" => "id", "foreignKey" => "municipio_id")
    );

    public function findForm($data, $fields) {
        $where = array(
            "order" => "razaoSocial ASC",
            "limit" => "10");
        if (empty($fields)) {
            $where["fields"] = array(
                "razaoSocial",
                "cnpj",
                "created",
                "id",
                "municipio_id",
                "estado_id"
            );
        } else {
            $where["fields"] = $fields;
        }

        if (!empty($data)) {
            $condicaoConsumo = array(
                "fields" => array("cliente_id"),
                "groupBy" => "cliente_id",
            );

            //Filtra clientes de acordo com consumo
            if ($data["categoria1"] > 0) {
                $condicaoConsumo["conditions"]["estoqueCategoria1"] = $data["categoria1"];
                if ($data["categoria2"] > 0) {
                    $condicaoConsumo["conditions"]["estoqueCategoria2"] = $data["categoria2"];
                    if ($data["categoria3"] > 0) {
                        $condicaoConsumo["conditions"]["estoqueCategoria3"] = $data["categoria3"];
                        if ($data["categoria4"] > 0) {
                            $condicaoConsumo["conditions"]["estoqueCategoria4"] = $data["categoria4"];
                        }
                    }
                }
                $modelConsumo = ClassRegistry::load("comercial_clientesconsumo");
                $clientesConsumo = $modelConsumo->all($condicaoConsumo);

                foreach ($clientesConsumo as $registro) {
                    $clientes[] = $registro["cliente_id"];
                }
            }
            if ($data["estado"] > 0) {
                $where["conditions"]["estado_id"] = $data["estado"];
            }
            if ($data["cidade"] > 0) {
                $where["conditions"]["municipio_id"] = $data["cidade"];
            }
            
            //Verifica se foi delimitado algum cliente para condição IN
            if (!empty($clientes)) {
                $where["conditions"]["id"] = $clientes;
            }
            
            $where["conditions"]["or"] = array(
                "nomeFantasia LIKE" => "%" . $data["nomeFantasia"] . "%",
                "razaoSocial LIKE" => "%" . $data["nomeFantasia"] . "%",
                "id" => $data["nomeFantasia"]
            );

            $where["limit"] = $data["limit"];
        }
        return $this->all($where);
    }

}

?>

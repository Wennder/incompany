<?php
class comercial_comportamentomercado extends AppModel{
    public $table = "comercial_comportamentoMercado";
    
    public $hasOne = array(
        "categoria1" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria1"
        ),
        "categoria2" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria2"
        ),
        "categoria3" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria3"
        ),
        "categoria4" => array(
            "className" => "estoque_catprodutos",
            "primaryKey" => "id",
            "foreignKey" => "estoqueCategoria4"
        )
    );
    
    public function dadosPeriodoGrafico($data){
        $condicao = array(
                    "conditions" => array(
                        "estoqueCategoria1" => $data["estoqueCategoria1"]
                    ),
                    "fields" => array(
                        "data",
                        "estoqueCategoria1",
                        "estoqueCategoria2",
                        "estoqueCategoria3",
                        "estoqueCategoria4",
                        "preco"
                    ),
                    "order"=>"data ASC"
                );
                if (!empty($data["dataInicio"]) && !empty($data["dataFim"])) {
                    $condicao["conditions"]["data >"] = implode("-",array_reverse(explode("-",$data["dataInicio"])));
                    $condicao["conditions"]["data <"] = implode("-",array_reverse(explode("-",$data["dataFim"])));
                }else{
                    $condicao["conditions"]["data >"] = ((date("Y")-1).date("-m-d"));
                    $condicao["conditions"]["data <"] = date("Y-m-d");
                }
                
                $resultSet = $this->all($condicao);
                
                foreach($resultSet as $dados){
                    $retorno[$dados["categoria2"]["nome"]][] = "[Date.UTC(".substr($dados["data"],0,4).",".(substr($dados["data"],5,2)-1).",".substr($dados["data"],8,2)."),{$dados["preco"]}]";
                }
                
                return $retorno;
    }
    
    public function dadosPeriodoGrid($data){
        $condicao = array(
                    "conditions" => array(
                        "estoqueCategoria1" => $data["estoqueCategoria1"]
                    ),
                    "fields" => array(
                        "id",
                        "data",
                        "estoqueCategoria1",
                        "estoqueCategoria2",
                        "estoqueCategoria3",
                        "estoqueCategoria4",
                        "preco"
                    ),
                    "order"=>"data ASC"
                );
                if (!empty($data["dataInicio"]) && !empty($data["dataFim"])) {
                    $condicao["conditions"]["data >"] = implode("-",array_reverse(explode("-",$data["dataInicio"])));
                    $condicao["conditions"]["data <"] = implode("-",array_reverse(explode("-",$data["dataFim"])));
                }else{
                    $condicao["conditions"]["data >"] = ((date("Y")-1).date("-m-d"));
                    $condicao["conditions"]["data <"] = date("Y-m-d");
                }
                
                $resultSet = $this->all($condicao);
                
                foreach($resultSet as $dados){
                    $retorno[$dados["categoria2"]["nome"]][] = array("id"=>$dados["id"],"data"=>$dados["data"],"preco"=>$dados["preco"]);
                }
                
                return $retorno;
    }
    
}
?>

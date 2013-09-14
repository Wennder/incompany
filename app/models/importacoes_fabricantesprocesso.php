<?php
class importacoes_fabricantesprocesso extends AppModel{
    public $table = "importacoes_fabricantesProcesso";
    
    public $hasOne = array(
        "fabricante" =>array("className"=>"estoque_fornecedores","primaryKey"=>"id","foreignKey"=>"fornecedores_id")
    );
    
    public function listRelatorio($processo){
        $condicao = array(
            "conditions"=>array(
                "processo"=>$processo
            )
        );
        $dadosLista = $this->all($condicao);
        if(count($dadosLista)>0){
            foreach($dadosLista as $fornecedor){
                $retorno .= $fornecedor["fabricante"]["razaoSocial"].",";
            }
            return $retorno;
        }else{
            return "Nenhum Fornecedor Informado";
        }
    }
}
?>

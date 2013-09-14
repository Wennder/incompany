<?php
    class importacoes_produtos extends AppModel{
        
        public $hasOne = array(
            "estoque_produtos"=>array(
                "className"=>"estoque_produtos",
                "primaryKey"=>"id",
                "foreignKey"=>"produto_id"
            )
        );
        
    }
?>

<?php
class estoque_catprodutos extends AppModel{
    public $table = "estoque_categoriaProdutos";
    public $hasMany = array(
        "filhos"=>array(
            "className"=>"estoque_catprodutos",
            "primaryKey"=>"id",
            "foreignKey"=>"pai"
        )
        );
}
?>

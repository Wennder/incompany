<?php
    class projetos_projeto extends AppModel
    {
        public $hasMany = array(
          "milestones"=>array("className"=>"projetos_milestones", "primaryKey"=>"id","foreignKey"=>"projetos_projeto_id"),
          "comentarios" => array(
              "className"=>"projetos_comentario","primaryKey"=>"id","foreignKey"=>"projetos_projeto_id"
          )
        );

        public $hasOne = array(
            "cliente"=>array(
                "className"=>"comercial_clientes","primaryKey"=>"id","foreignKey"=>"cliente"),
            "responsavel"=>array(
                "className"=>"rh_funcionarios","primaryKey"=>"id","foreignKey"=>"responsavel")
            );

    }
?>

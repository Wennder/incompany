<?php

    class projetos_atividades extends AppModel
    {
        public $hasMany = array(
          "comentarios" => array(
              "className"=>"projetos_comentario","primaryKey"=>"id","foreignKey"=>"projetos_atividades_id"
          )
        );
        public $hasOne =
            array("projetos_projeto",array("className"=>"projetos_projeto","primaryKey"=>"id","foreignKey"=>"projetos_projeto_id"),
            "projetos_milestones",array("className"=>"projetos_milestones","primaryKey"=>"id","foreignKey"=>"projetos_milestones_id")
            );
    }

?>

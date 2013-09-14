<?php

    class projetos_milestones extends AppModel{
        public $hasMany = array(
            "atividades"=>array("className"=>"projetos_milestones","primaryKey"=>"projetos_milestones_id","foreignKey"=>"id")
        );
    }

?>

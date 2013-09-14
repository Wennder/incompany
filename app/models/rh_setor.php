<?php
/**
 *  AppModel é o model usado como base para todos os outros models da aplicação.
 *  Como está na biblioteca, é usado apenas quando não houver outro AppModel
 *  definido pelo usuário.
 *
 *  @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 *  @copyright Copyright 2008-2009, Spaghetti* Framework (http://spaghettiphp.org/)
 *
 */
    
class rh_setor extends AppModel {
    public $primaryKey = "id";
    //public $belongsTo = array("rh_funcionarios"=>array("foreignKey" => "rh_setor_id"));
    public $hasOne = array("sys_permissoes"=>array("primaryKey"=>"id","foreignKey"=>"sys_permissoes_id"));
    
}
?>
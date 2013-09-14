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

class ocorrencia extends AppModel {
    public $primaryKey = "id";
    public $table="financeiro_reembolsos";
    public $hasOne = array("rh_funcionarios"=>array("className"=>"rh_funcionarios","primaryKey"=>"id","foreignKey"=>"beneficiario"),
                            "tipodespesa"=>array("className"=>"tipodespesa","primaryKey"=>"id","foreignKey"=>"tipodespesa_id"),
                            "financeiro_motivodespesa"=>array("className"=>"financeiro_motivodespesa","primaryKey"=>"id","foreignKey"=>"motivodespesa_id"),
                            "financeiroPago"=>array("className"=>"rh_funcionarios","primaryKey"=>"id","foreignKey"=>"pagoPor","recursion"=>"-2"));
   
    }
?>
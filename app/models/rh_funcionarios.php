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
    
class rh_funcionarios extends AppModel {
    public $primaryKey = "id";
    public $hasOne = array(
        "rh_setor"=>array("className"=>"rh_setor","primaryKey"=>"id","foreignKey"=>"rh_setor_id"),
        "grupoEmpresa"=>array("className"=>"SysGrupoEmpresa","primaryKey"=>"id","foreignKey"=>"grupoEmpresa_id"),
        "empresa"=>array("className"=>"sys_empresas","primaryKey"=>"id","foreignKey"=>"empresa_id"),
        "financeiro_bancos"=>array("className"=>"financeiro_bancos","primaryKey"=>"id","foreignKey"=>"financeiro_bancos_id"),
        "gerenteFuncionario"=>array("className"=>"rh_funcionarios","primaryKey"=>"id","foreignKey"=>"gerente_id"),
        "foto"=>array("className"=>"rh_docs","primaryKey"=>"users_id","foreignKey"=>"id","conditions"=>array("tipoDoc"=>"1"))
        

        );
    

	public function beforeSave($data) {
            if (!empty($data["password"])){
		$data["password"] = Security::hash($data["password"], "sha1", true);
            }
		return $data;
	}
	
}
?>
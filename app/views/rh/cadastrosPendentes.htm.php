<?php    
$this->pageTitle = "RH :: Cadastros Pendentes";
    echo $xgrid->start($dadosUsuarios)
            ->caption("Funcionários")
            ->hidden(array('id','username','dt_desligamento','rh_setor_id','grupoEmpresa_id','sysEmpresas_id','rh_setor','financeiro_bancos','gerente_funcionario','foto'))
            ->col('username')->hidden()
            ->col('nome')->title('Nome')->slice(50)
            ->col('empresa')->cellArray('nomeFantasia')
            ->col('dt_desligamento')->hidden()
            ->col('grupo_empresa')->title('Grupo')->cellArray('nome')
            ->col('rh_setor_id')->hidden()
            ->col('  ')->conditions('id', array(
                  ">=1" => array("label"=>"editar.png","href"=>"/rh/cadFuncionario/{id}", "border"=>"0")
            ))
            ->noData('Nenhum Cadastro Aguardando')
            ->alternate("grid_claro","grid_escuro");    
?>
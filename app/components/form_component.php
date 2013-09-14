<?php

class FormComponent extends Component {

    public function options($model, $displayField, $campo, $condicao) {
        $model = ClassRegistry::load($model, "Model");
        $conditions = array(
            "conditions" => array(
                $campo => $condicao
            ),
            "displayField" => $displayField
        );
        $options = $model->toList($conditions);
        $retorno = "";
        foreach ($options as $key => $value) {
            $retorno .= "<option value='$key'>$value</option>";
        }
        return $retorno;
    }

    public function dateFormat($format, $date) {
        if (!empty($date) and ($date != "00-00-0000")) {
            if ($date != "0000-00-00") {

                $timestamp = strtotime($date);
                $retorno = date($format, $timestamp);
            }
        } else {
            $retorno = "";
        }
        return $retorno;
    }

    public function formatarValorBoleto($input) {
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = $length . "." . substr($input, -2);
        return $formatted_input;
    }

    public function formatarDataBoleto($input){
        $ano = substr($input, 4,4);
        $mes = substr($input, 2,2);
        $dia = substr($input, 0,2);
        return $ano."-".$mes."-".$dia;
    }
    
    public function funcionariosAtivos($grupoEmpresa, $tipoRetorno="array"){
        $model = ClassRegistry::load("rh_funcionarios", "Model");
        $condicao = array(
            "conditions"=>array(
                "grupoEmpresa_id"=>$grupoEmpresa,
                "dt_desligamento"=>"0000-00-00"
            ),
            "order"=>"nome",
            "displayField"=>"nome"
        );
        if($tipoRetorno=="array"){
            return $model->all($condicao);
        }else{
            return $model->toList($condicao);
        }
    }
    
    public function dataMysql($data){
        return implode("-",array_reverse(explode("-",$data)));
    }

}
?>

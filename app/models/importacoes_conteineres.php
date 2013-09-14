<?php

class importacoes_conteineres extends AppModel {

    public $hasOne = array(
        "transportadora" => array(
            "className" => "estoque_transportadoras",
            "primaryKey" => "id",
            "foreignKey" => "transportadora_id"
        )
    );

    public function toGrid($conditions) {
        $dadosGrid = $this->all($conditions);
        $retorno = "<table width='100%' style='font-family:Arial, Helvetica, sans-serif; font-size:11px;'>
            <caption style='background-color:#036292; color:#dde8ed; font-size:14px;font-weight:bold;'>Conteineres do Processo</caption>
            <thead bgcolor='#6ab6dc' style='color:#FFF;'>
		<tr>
			<th id='header-numero'>Numero</th>
			<th id='header-lacre'>Lacre</th>
			<th id='header-transportadora'>Armador</th>
		</tr>
	</thead><tbody>";
        if(count($dadosGrid)>0) {
            $i = 0;
            foreach ($dadosGrid as $dado) {
                if (($i % 2) != 0) {
                    $color = "#FFFFFF";
                } else {
                    $color = "#e4eef1";
                }
                $i++;
                $retorno .= "<tr bgcolor='$color'>
			<td headers='header-numero'>{$dado["numero"]}</td>
			<td headers='header-lacre'>{$dado["lacre"]}</td>
			<td headers='header-transportadora'>{$dado["transportadora"]["nomeFantasia"]}</td>
		</tr>";
            }
        } else {
            $retorno .= "<tr bgcolor='$color'>
			<td colspan=3 align='center'>Nenhum Registro Encontrado</td>
			
		</tr>";
        }
        return $retorno . "</tbody></table>";
    }

}

?>

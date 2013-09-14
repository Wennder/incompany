<?php

class importacoes_anexos extends AppModel {

    public function toGridCliente($condicao) {
        $condicao["conditions"]["visibilidade"] = "1";
        $dadosGrid = $this->all($condicao);
        $retorno = "<table width='100%' style='font-family:Arial, Helvetica, sans-serif; font-size:11px;'>
            <caption style='background-color:#036292; color:#dde8ed; font-size:14px;font-weight:bold;'>Documentos Disponibilizados</caption>
            <thead bgcolor='#6ab6dc' style='color:#FFF;'>
		<tr>
			<th id='header-descricao'>Descrição</th>
			<th id='header-numero'>Número</th>
			<th id='header-arquivo'>Arquivo</th>
		</tr>
	</thead><tbody>";
        if (count($dadosGrid) > 0) {
            $i = 0;
            foreach ($dadosGrid as $dado) {
                if (($i % 2) != 0) {
                    $color = "#FFFFFF";
                } else {
                    $color = "#e4eef1";
                }
                $i++;
                $retorno .= "<tr bgcolor='$color'>
			<td headers='header-descricao'>{$dado["descricao"]}</td>
			<td headers='header-nro'>{$dado["nro"]}</td>
			<td headers='header-arquivo'><a href='http://{$_SERVER['HTTP_HOST']}{$dado["arquivo"]}'>Visualizar Arquivo</a></td>
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
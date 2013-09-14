<?php
class WebservicesHelper extends Helper {

    function consultaCep($cep) {
        $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep=' . $cep . '&formato=json');
        if (empty($resultado)) {
            $resultado = "&resultado=0&resultado_txt=Erro+ao+Buscar+CEP";
        }
        parse_str($resultado, $retorno);
        return $resultado;
    }

    public function cotacaoMoedas() {
        $resultado = @file_get_contents('http://republicavirtual.com.br/web_cotacao.php?formato=xml');
        if (empty($resultado)) {
            $resultado = "&resultado=0&resultado_txt=Erro+ao+Buscar+Cotações";
        }
        parse_str($resultado, $retorno);
        return $resultado;
    }

}

?>

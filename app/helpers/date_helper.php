<?php

/**
 *  DateHelper provê funções de formatação de data.
 *
 *  @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 *  @copyright Copyright 2008-2009, Spaghetti* Framework (http://spaghettiphp.org/)
 *
 */
class DateHelper extends Helper {

    /**
     *  Formata uma data.
     *
     *  @param string $format Formato de data
     *  @param string $date Data compatível com strtotime
     *  @return string Data formatada
     */
    public function format($format, $date) {
        if (!empty($date) and ($date != "00-00-0000")) {
            if ($date != "0000-00-00") {
                $timestamp = strtotime($date);
                $retorno = date($format, $timestamp);
            }
        } else {
            $retorno = "-";
        }
        return $retorno;
    }

    public function diff($inicio, $fim) {
        $date1 = $inicio;
        $date2 = $fim;

        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        if ($years == 0) {
            $years = "";
        } elseif ($years > 0 && $years < 2) {
            $years = "$years ano e ";
        } elseif ($years > 1) {
            $years = "$years anos e ";
        }

        if ($months > 0 && $months < 2) {
            $months = "$months mês";
        } elseif ($months > 1) {
            $months = "$months meses";
        }

        if ($days > 0 && $days < 2) {
            $days = " e $days dia";
        } elseif ($days > 1) {
            $days = " e $days dias";
        }


        return "$years$months";
    }

    function diffDate($d1, $d2, $type = '', $sep = '-') {
        $d1 = explode($sep, $d1);
        $d2 = explode($sep, $d2);
        switch ($type) {
            case 'A':
                $X = 31536000;
                break;
            case 'M':
                $X = 2592000;
                break;
            case 'D':
                $X = 86400;
                break;
            case 'H':
                $X = 3600;
                break;
            case 'MI':
                $X = 60;
                break;
            default:
                $X = 1;
        }
        return floor((( mktime(0, 0, 0, $d2[1], $d2[2], $d2[0]) - mktime(0, 0, 0, $d1[1], $d1[2], $d1[0]))/$X));
    }

    public function month($monthNumber) {
        $month = array(
            1 => "Jan",
            2 => "Fev",
            3 => "Mar",
            4 => "Abr",
            5 => "Mai",
            6 => "Jun",
            7 => "Jul",
            8 => "Ago",
            9 => "Set",
            10 => "Out",
            11 => "Nov",
            12 => "Dez"
        );
        return $month[$monthNumber];
    }

    function dataExtenso($strDate) {
        // Array com os dia da semana em português;
        $arrDaysOfWeek = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
        // Array com os meses do ano em português;
        $arrMonthsOfYear = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        // Descobre o dia da semana
        $intDayOfWeek = date('w', strtotime($strDate));
        // Descobre o dia do mês
        $intDayOfMonth = date('d', strtotime($strDate));
        // Descobre o mês
        $intMonthOfYear = date('n', strtotime($strDate));
        // Descobre o ano
        $intYear = date('Y', strtotime($strDate));
        // Formato a ser retornado
        //
        // retorna nomeDiaSemana,diaSemana,Mês,Ano
        // return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
        //este retorna ,diaSemana,Mês,Ano
        return $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
    }

}

?>
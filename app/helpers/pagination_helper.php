<?php
/**
 *  GeraÃ§Ã£o automÃ¡tica dos elementos HTML para uso com a paginaÃ§Ã£o.
 *
 *  @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 *  @copyright Copyright 2008-2009, Spaghetti* Framework (http://spaghettiphp.org/)
 *
 */

App::import("Helper", "html_helper");

class PaginationHelper extends HtmlHelper {
    /**
     *  Model a ser utilizado na paginaÃ§Ã£o.
     */
    public $model = false;

    /**
     *  Carrega o Model a ser utilizado na paginaÃ§Ã£o.
     *
     *  @param string $model Model utilizado
     *  @return object
     */
    public function model($model) {
        return $this->model = ClassRegistry::load($model);
    }
    /**
     *  Gera uma lista de pÃ¡ginas.
     *
     *  @param array $options OpÃ§Ãµes da lista
     *  @return string Lista de pÃ¡ginas
     */
    public function numbers($options = array()) {
        $options = array_merge(
            array(
                "modulus" => 3,
                "separator" => " ",
                "tag" => "span",
                "current" => "current"
            ),
            $options
        );
        $page = $this->model->pagination["page"];
        $pages = $this->model->pagination["totalPages"];
        $numbers = array();
        for($i = $page - $options["modulus"]; $i <= $page + $options["modulus"]; $i++):
            if($i > 0 && $i <= $pages):
                if($i != $page):
                    $attributes = array();
                    $number = $this->link($i, array("page" => $i));
                else:
                    $attributes = array("class" => $options["current"]);
                    $number = $i;
                endif;
                $numbers []= $this->tag($options["tag"], $number, $attributes);
            endif;
        endfor;
        return join($options["separator"], $numbers);
    }
    /**
     *  Gera o link para a pÃ¡gina seguinte de acordo com os dados encontrados.
     *
     *  @param string $text Texto a ser expresso no link
     *  @param array $attr Atributos extras para o link
     *  @return string Link para a pÃ¡gina seguinte
     */
    public function next($text, $attr = array()) {
        if($this->hasNext()):
            $page = $this->model->pagination["page"] + 1;
            return $this->link($text, array("page" => $page), $attr);
        endif;
        return "";
    }
    /**
     *  Gera o link para a pÃ¡gina anterior de acordo com os dados encontrados.
     *
     *  @param string $text Texto a ser expresso no link
     *  @param array $attr Atributos extras para o link
     *  @return string Link para a pÃ¡gina anterior
     */
    public function previous($text, $attr = array()) {
        if($this->hasPrevious()):
            $page = $this->model->pagination["page"] - 1;
            return $this->link($text, array("page" => $page), $attr);
        endif;
        return "";
    }
    /**
     *  Gera o link para a pÃ¡gina inicial de acordo com os dados encontrados.
     *
     *  @param string $text Texto a ser expresso no link
     *  @param array $attr Atributos extras para o link
     *  @return string Link para a pÃ¡gina inicial
     */
    public function first($text, $attr = array()) {
        if($this->hasPrevious()):
            $page = 1;
            return $this->link($text, array("page" => $page), $attr);
        endif;
        return "";
    }
    /**
     *  Gera o link para a pÃ¡gina final de acordo com os dados encontrados.
     *
     *  @param string $text Texto a ser expresso no link
     *  @param array $attr Atributos extras para o link
     *  @return string Link para a pÃ¡gina final
     */
    public function last($text, $attr = array()) {
        if($this->hasNext()):
            $page = $this->model->pagination["totalPages"];
            return $this->link($text, array("page" => $page), $attr);
        endif;
        return "";
    }
    /**
     *  Verifica a existÃªncia da pÃ¡gina seguinte caso nÃ£o esteja na Ãºltima pÃ¡gina.
     *
     *  @return boolean Verdadeiro caso exista uma prÃ³xima pÃ¡gina
     */
    public function hasNext() {
        if($this->model):
            return $this->model->pagination["page"] < $this->model->pagination["totalPages"];
        endif;
        return null;
    }
    /**
     *  Verifica a existÃªncia da pÃ¡gina anterior caso nÃ£o esteja na primeira pÃ¡gina.
     *
     *  @return boolean Verdadeiro caso exista uma pÃ¡gina anterior
     */
    public function hasPrevious() {
        if($this->model):
            return $this->model->pagination["page"] != 1;
        endif;
        return null;
    }
}

?>
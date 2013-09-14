<?php
session_start();
/**
 *  Se você está vendo esse arquivo, provavelmente o mod_rewrite ou .htaccess não
 *  são suportados ou não estão habilitados no servidor.
 *
 *  @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 *  @copyright Copyright 2008-2009, Spaghetti* Framework (http://spaghettiphp.org/)
 *
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <title>Erro - Spaghetti* Framework</title>
		
    </head>
    
    <body>
        <header>
            <a href="http://spaghettiphp.org" id="logo">Spaghetti<span>*</span></a>
        </header>

		<section id="error">
        	<h1>O Spaghetti* não conseguiu iniciar!</h1>
            <?php if(!function_exists("apache_get_version")): ?>
            <p>Isso se deve ao servidor que você está usando. O Spaghett* já vem pronto para ser usado com o Apache. Se você usa outro servidor, você precisará configurá-lo para funcionar com as regras de reescrita de URL requeridas pelo Spaghetti*.</p>
            <?php elseif(!in_array("mod_rewrite", apache_get_modules())): ?>
            <p>Para que o Spaghetti* funcione corretamente, você precisa habilitar o módulo de reescrita de URL do Apache, o <strong>mod_rewrite</strong>.</p>
            <?php else: ?>
            <p>Você tem tudo o que precisa para rodar o Spaghetti*, entretanto, seu servidor não permite que as URLs sejam escritas. Você precisa definir a diretiva <strong>AllowOverride</strong> com pelo menos <strong>Options</strong> e <strong>FileInfo</strong> para que o Spaghetti* possa funcionar.</p>
            <?php endif ?>
        </section>

        <footer>
            <p>Obrigado por usar Spaghetti* :)</p>
        </footer>
    </body>
</html>
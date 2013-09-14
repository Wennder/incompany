<div id="avisoSistema">
    <?php
        if (!empty($mensagens) || $mensagens = Session::flash("Auth.error")) {
        echo $mensagens;
        ?>
        <script type="text/javascript" >
            $("#avisoSistema").dialog("open");
        </script>
        <?php
    }
    ?>
</div>
<?php
echo $form->create("/site");
echo $form->input("username", array("type" => "text", "label" => "Email", "class" => "Form1Bloco"));
echo $form->input("password", array("type" => "password", "label" => "Senha", "class" => "Form1Bloco"));
echo "<br/>";
echo $form->close("", array("class" => "logar","style"=>"float:left;"));

echo $html->imageLink("/nLayout/btn_esqueciSenha.png","/site/cadastrarSenha",array(),array("style"=>"margin-left: 20px;"));
?>
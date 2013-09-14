
<script type="text/javascript">
    $(document).ready(function(){
    $('.boxEquipe').corner();

    });
</script>

<fieldset>

    <legend><div class="titulo">Equipe</div></legend>
<?php
foreach ($equipe as $funcionario) {

    echo "<div class=\"boxEquipe\">";
    
    $foto = $assistec->getPhoto($funcionario["foto"]["file"]);
   $foto = $html->image($foto["url"], array("width" => "90%", "bd" => $foto["bd"]), true);

    $nome = $funcionario["nome"];
?>
    <a href="javascript:popIn('janelaModal','/rh/fichaFuncionario/<?php echo $funcionario['id']; ?>');"><center><?php echo $foto; echo $nome; ?></center></a>
<?php
    echo "</div>";
}
?>
</fieldset>

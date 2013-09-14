<div class="fontPrintficha">
 <?php   pr($dadosContato);?>
    <table border="1">
             <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Nome</b><br/><?php echo $dadosContato['nome'];?></td>
               
            </tr>
            <tr>
                 <td><b>Email</b><br/><?php echo $dadosContato['email'];?></td>
                </tr>
            <tr>
                <td><b>Telefone 1</b><br/><?php echo $dadosContato['tel1'];?></td>
                <td><b>Telefone 2</b><br/><?php echo $dadosContato['tel2'];?></td>
            </tr>
                    
    </table>

</div>
<!-- Start PureCSSMenu.com MENU -->
<ul class="pureCssMenu pureCssMenum">
    
<li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img src="/images/iconesMenu/cart.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/itensProcesso/cadastrar/<?php echo $op ?>',440,275,'Adicionar Produtos à Importação',0,true);">+ Produto</a></li>

        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img src="/images/iconesMenu/money_add.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span>Despesas</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul class="pureCssMenum">
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/despesasNacionalizacao/cadastrar/<?php echo $op ?>', 500, 600, 'Despesas de Nacionalização', 0, true);">Itens</a></li>
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/despesasNacionalizacao/setTerminal/<?php echo $op ?>',440,210,'Alteração de Terminal',0,true);">Terminal</a></li>
                </ul>
                <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>

<li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img alt="Relatórios" src="/images/iconesMenu/printer.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="/relatorios/importacoes_planilha/<?php echo $op ?>" target="_blank">Visão Geral</a></li>
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/relatorios/importacoes_precovenda/filtro/<?php echo $op; ?>',420,210,'Imprimir Relatório: Formação de Preço de Venda',0,true);" target="_blank">Preço Venda</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:recalculaProcesso(<?php echo $op ?>);"><span><img alt="Recalcular" src="/images/iconesMenu/calculator_black.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);" id="salvaProcesso"><span><img alt="Salvar" src="/images/iconesMenu/disk.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:confirma('Deseja tornar ese processo em PEDIDO?','/importacoes/setPedido/<?php echo $op; ?>');" id="salvaProcesso"><span><img alt="Pedido" src="/images/iconesMenu/accept.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
</ul>
<div id="ultimoSave" style="margin-top: 10px;margin-right: 10px; color: #000000;float:right; font-weight: bold; font-size: 16px;"></div>

<!-- End PureCSSMenu.com MENU -->




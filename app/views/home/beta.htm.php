<script>
    $(function(){
        
    
        $('.homeSistema').sortable(
        {
        
            helperclass: 'sortHelper',
            activeclass : 	'sortableactive',
            hoverclass : 	'sortablehover',
            handle: '.title',
            tolerance: 'pointer',
            onChange : function(ser)
            {
            },
            onStart : function()
            {
                $.iAutoscroller.start(this, document.getElementsByTagName('body'));
            },
            onStop : function()
            {
                $.iAutoscroller.stop();
            }
        }
    );
    });
</script>
<div class="homeSistema">
    <div class="grid_4">
        <div class="caixa">   

            <div class="title">
                <h3>Mensageiro</h3><a href="javascript:void(0);"><img src="/images/templateImages/seta.png"></a>
            </div><!-- .title -->

            <div class="borda">
                <table border="0">
                    <tbody><tr>
                            <td rowspan="2"><img src="/images/templateImages/table-cal.jpg"></td>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                        <tr>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                    </tbody></table>
            </div><!-- .borda -->

        </div>
        <p>&nbsp</p>
    </div>


    <div class="grid_4">
        <div class="caixa">

            <div class="title">
                <h3>Avisos de Atracação</h3><a href="javascript:void(0);"><img src="/images/templateImages/seta.png"></a>
            </div><!-- .title -->

            <div class="borda">
                <table border="0">
                    <tbody><tr>
                            <td rowspan="2"><img src="/images/templateImages/table-cal.jpg"></td>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                        <tr>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                    </tbody></table>
            </div><!-- .borda -->

        </div>
        <p>&nbsp</p>
    </div>

    <div class="grid_4">
        <div class="caixa">   

            <div class="title">
                <h3>Posição Financeira</h3><a href="javascript:void(0);"><img src="/images/templateImages/seta.png"></a>
            </div><!-- .title -->

            <div class="borda tamanho1">
                <table border="0">
                    <tbody><tr>
                            <td rowspan="2"><img src="/images/templateImages/table-cal.jpg"></td>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                        <tr>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                    </tbody></table>
            </div><!-- .borda -->

        </div>
    </div>

    <div class="grid_4">
        <div class="caixa">   

            <div class="title">
                <h3>Comercial</h3><a href="javascript:void(0);"><img src="/images/templateImages/seta.png"></a>
            </div><!-- .title -->

            <div class="borda tamanho1">
                <table border="0">
                    <tbody><tr>
                            <td rowspan="2"><img src="/images/templateImages/table-cal.jpg"></td>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                        <tr>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                    </tbody></table>
            </div><!-- .borda -->

        </div>
    </div>
    
    <div class="grid_4">
        <div class="caixa">   

            <div class="title">
                <h3>Comercial</h3><a href="javascript:void(0);"><img src="/images/templateImages/seta.png"></a>
            </div><!-- .title -->

            <div class="borda tamanho1">
                <table border="0">
                    <tbody><tr>
                            <td rowspan="2"><img src="/images/templateImages/table-cal.jpg"></td>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                        <tr>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                    </tbody></table>
            </div><!-- .borda -->

        </div>
    </div>
    
    <div class="grid_4">
        <div class="caixa">   

            <div class="title">
                <h3>Comercial</h3><a href="javascript:void(0);"><img src="/images/templateImages/seta.png"></a>
            </div><!-- .title -->

            <div class="borda tamanho1">
                <table border="0">
                    <tbody><tr>
                            <td rowspan="2"><img src="/images/templateImages/table-cal.jpg"></td>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                        <tr>
                            <td><img src="/images/templateImages/table-cal.jpg" width="153" height="150"></td>
                        </tr>
                    </tbody></table>
            </div><!-- .borda -->

        </div>
    </div>
</div>